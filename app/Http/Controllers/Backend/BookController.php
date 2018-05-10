<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Book;


use Helper, File, Session, Auth, Hash, URL, Image;

class BookController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function change(Request $request){
        $parent_id = isset($request->parent_id) ? $request->parent_id : null;
        $cate_id = isset($request->cate_id) ? $request->cate_id : null;    
        return view('backend.book.change', compact('parent_id', 'cate_id'));   
    }
    public function index(Request $request)
    {   
        $arrSearch['folder_id'] = $folder_id = isset($request->folder_id) ? $request->folder_id : null;
        $arrSearch['author_id'] = $author_id = isset($request->author_id) ? $request->author_id : null;
        $arrSearch['status'] = $status = isset($request->status) ? $request->status : 1;    
        $arrSearch['created_user'] = $created_user = isset($request->created_user) ? $request->created_user : null;        
        $arrSearch['keyword'] = $keyword = isset($request->keyword) && trim($request->keyword) != '' ? trim($request->keyword) : '';
        
        $query = Book::where('book.status', $status);
        
        if( $folder_id ){
            $query->where('book.folder_id', $folder_id);
        }
        if( $author_id ){
            $query->where('book.author_id', $author_id);
        }
        if( $created_user ){
            $query->where('book.created_user', $created_user);
        }         
        if( $keyword != ''){
            $query->where('book.name', 'LIKE', '%'.$keyword.'%');           
            $query->orWhere('book.id', 'LIKE', '%'.$keyword.'%');
        } 
        $query->orderBy('book.display_order', 'asc')->orderBy('book.id', 'desc');
        $items = $query->paginate(100);        

        return view('backend.book.index', compact( 'items', 'arrSearch'));        
    }
   
   
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {       
        $folder_id = $request->folder_id ? $request->folder_id : null;
        $author_id = $request->author_id ? $request->author_id : null;
        
        return view('backend.book.create', compact('author_id', 'folder_id'));
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
            'folder_id' => 'required',
            'author_id' => 'required',            
            'name' => 'required'
        ],
        [   
            'folder_id.required' => 'Please choose folder',
            'author_id.required' => 'Please choose author',            
            'name.required' => 'Please input name',
        ]);
           
        $dataArr['slug'] = str_slug($dataArr['name']);
        $dataArr['status'] = 1;
        $dataArr['display_order'] = Helper::getNextOrder('book',['folder_id' => $dataArr['folder_id']]);
        $dataArr['created_user'] = Auth::user()->id;
        $dataArr['updated_user'] = Auth::user()->id;              

        $rs = Book::create($dataArr);
        $product_id = $rs->id;

        Session::flash('message', trans('text.success'));

        return redirect()->route('book.index', ['folder_id' => $dataArr['folder_id'], 'author_id' => $dataArr['author_id']]);
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
        $detail = Book::find($id); 

        return view('backend.book.edit', compact( 'detail'));
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
            'folder_id' => 'required',
            'author_id' => 'required',            
            'name' => 'required'
        ],
        [   
            'folder_id.required' => 'Please choose folder',
            'author_id.required' => 'Please choose author',            
            'name.required' => 'Please input name',
        ]);
        $dataArr['slug'] = str_slug($dataArr['name']);     
        $dataArr['updated_user'] = Auth::user()->id;        
        
        $model = Book::find($dataArr['id']);

        $model->update($dataArr);

        Session::flash('message', trans('text.success'));

        return redirect()->route('book.index', ['folder_id' => $dataArr['folder_id'], 'author_id' => $dataArr['author_id']]);
        
    }
    public function ajaxSaveInfo(Request $request){
        
        $dataArr = $request->all();

        $dataArr['alias'] = Helper::stripUnicode($dataArr['name']);
        
        $dataArr['updated_user'] = Auth::user()->id;
        
        $model = Book::find($dataArr['id']);

        $model->update($dataArr);
        
        $product_id = $dataArr['id'];        

        Session::flash('message', 'Chỉnh sửa thành công');

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
        $model = Book::find($id);        
        $model->delete();
        Rating::where('object_id', $id)->where('object_type', 1)->delete();
        // redirect
        Session::flash('message', 'Xóa thành công');
        
        return redirect(URL::previous());
        
    }
}
