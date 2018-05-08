<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ArticlesCate;
use App\Models\Tag;
use App\Models\TagObjects;
use App\Models\Articles;
use App\Models\MetaData;
use App\Models\Rating;

use Helper, File, Session, Auth, Image;

class ArticlesController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {   
        
        $cate_id = isset($request->cate_id) ? $request->cate_id : null;

        $title = isset($request->title) && $request->title != '' ? $request->title : '';
        
        $query = Articles::where('type', 1)->where('status', 1);

        if( $cate_id > 0){
            $query->where('cate_id', $cate_id);
        }
        // check editor
        if( Auth::user()->role < 3 ){
            $query->where('created_user', Auth::user()->id);
        }
        if( $title != ''){
            $query->where('alias', 'LIKE', '%'.$title.'%');
        }

        $items = $query->orderBy('is_hot', 'desc')->orderBy('id', 'desc')->paginate(20);
        
        $cateArr = ArticlesCate::where('type', 1)->get();
        
        return view('backend.articles.index', compact( 'items', 'cateArr' , 'title', 'cate_id' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        
        $cateArr = ArticlesCate::where('type', 1)->get();
        
        $cate_id = $request->cate_id;

        $tagArr = Tag::where('type', 2)->orderBy('id', 'desc')->get();

        return view('backend.articles.create', compact( 'tagArr', 'cateArr', 'cate_id'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  Request  $request
    * @return Response
    */
    public function store(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[            
            'cate_id' => 'required',            
            'title' => 'required',            
            'slug' => 'required|unique:articles,slug',
        ],
        [            
            'cate_id.required' => 'Bạn chưa chọn danh mục',            
            'title.required' => 'Bạn chưa nhập tiêu đề',
            'slug.required' => 'Bạn chưa nhập slug',
            'slug.unique' => 'Slug đã được sử dụng.'
        ]);       
        
        $dataArr['alias'] = Helper::stripUnicode($dataArr['title']);      
        
        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;
        $dataArr['type'] = 1;
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;  

        $rs = Articles::create($dataArr);

        $object_id = $rs->id;

        $this->storeMeta( $object_id, 0, $dataArr);

        // xu ly tags
        if( !empty( $dataArr['tags'] ) && $object_id ){
            

            foreach ($dataArr['tags'] as $tag_id) {
                $model = new TagObjects;
                $model->object_id = $object_id;
                $model->tag_id  = $tag_id;
                $model->type = 2;
                $model->save();
            }
        }

        // store Rating
        for($i = 1; $i <= 5 ; $i++ ){
            $amount = $i == 5 ? 1 : 0;
            Rating::create(['score' => $i, 'object_id' => $object_id, 'object_type' => 2, 'amount' => $amount]);
        }

        Session::flash('message', 'Tạo mới thành công');

        return redirect()->route('articles.index',['cate_id' => $dataArr['cate_id']]);
    }
    public function storeMeta( $id, $meta_id, $dataArr ){
       
        $arrData = [ 'title' => $dataArr['meta_title'], 'description' => $dataArr['meta_description'], 'keywords'=> $dataArr['meta_keywords'], 'custom_text' => $dataArr['custom_text'], 'updated_user' => Auth::user()->id ];
        if( $meta_id == 0){
            $arrData['created_user'] = Auth::user()->id;            
            $rs = MetaData::create( $arrData );
            $meta_id = $rs->id;
            
            $modelSp = Articles::find( $id );
            $modelSp->meta_id = $meta_id;
            $modelSp->save();
        }else {
            $model = MetaData::find($meta_id);           
            $model->update( $arrData );
        }              
    }
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
    //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        
        $tagSelected = [];

        $detail = Articles::find($id);
        if( Auth::user()->role < 3 ){
            if($detail->created_user != Auth::user()->id){
                return redirect()->route('product.index');
            }
        }
        $cateArr = ArticlesCate::where('type', 1)->get();    

        $tmpArr = TagObjects::where(['type' => 2, 'object_id' => $id])->get();
        
        if( $tmpArr->count() > 0 ){
            foreach ($tmpArr as $value) {
                $tagSelected[] = $value->tag_id;
            }
        }
        
        $tagArr = Tag::where('type', 2)->get();
        $meta = (object) [];
        if ( $detail->meta_id > 0){
            $meta = MetaData::find( $detail->meta_id );
        }

        return view('backend.articles.edit', compact('tagArr', 'tagSelected', 'detail', 'cateArr', 'meta'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[            
            'cate_id' => 'required',            
            'title' => 'required',            
            'slug' => 'required|unique:articles,slug,'.$dataArr['id'],
        ],
        [            
            'cate_id.required' => 'Bạn chưa chọn danh mục',            
            'title.required' => 'Bạn chưa nhập tiêu đề',
            'slug.required' => 'Bạn chưa nhập slug',
            'slug.unique' => 'Slug đã được sử dụng.'
        ]);       
        
        $dataArr['alias'] = Helper::stripUnicode($dataArr['title']);
        
        $dataArr['type'] = 1;
        $dataArr['updated_user'] = Auth::user()->id;
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;  
         
        $model = Articles::find($dataArr['id']);

        $model->update($dataArr);
        
        $this->storeMeta( $dataArr['id'], $dataArr['meta_id'], $dataArr);

        TagObjects::where(['object_id' => $dataArr['id'], 'type' => 2])->delete();
        // xu ly tags
        if( !empty( $dataArr['tags'] ) ){
                       
            foreach ($dataArr['tags'] as $tag_id) {
                $modelTagObject = new TagObjects; 
                $modelTagObject->object_id = $dataArr['id'];
                $modelTagObject->tag_id  = $tag_id;
                $modelTagObject->type = 2;
                $modelTagObject->save();
            }
        }
        Session::flash('message', 'Cập nhật thành công');        

        return redirect()->route('articles.edit', $dataArr['id']);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        // delete
        $model = Articles::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('articles.index');
    }
}
