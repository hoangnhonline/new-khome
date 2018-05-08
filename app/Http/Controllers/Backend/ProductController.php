<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\CateType;
use App\Models\CateParent;
use App\Models\Cate;
use App\Models\ProductImg;
use App\Models\MetaData;
use App\Models\Tag;
use App\Models\TagObjects;
use App\Models\ThongSo;
use App\Models\Rating;
use App\Models\Grand;


use Helper, File, Session, Auth, Hash, URL, Image;

class ProductController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function change(Request $request){
        $parent_id = isset($request->parent_id) ? $request->parent_id : null;
        $cate_id = isset($request->cate_id) ? $request->cate_id : null;    
        return view('backend.product.change', compact('parent_id', 'cate_id'));   
    }
    public function index(Request $request)
    {   
        $arrSearch['parent_id'] = $parent_id = isset($request->parent_id) ? $request->parent_id : null;
        $arrSearch['cate_id'] = $cate_id = isset($request->cate_id) ? $request->cate_id : null;    
        $arrSearch['grand_id'] = $grand_id = isset($request->grand_id) ? $request->grand_id : null;        
        $arrSearch['code'] = $code = isset($request->code) && trim($request->code) != '' ? trim($request->code) : '';
        $arrSearch['status'] = $status = isset($request->status) ? $request->status : 1;
        $arrSearch['is_hot'] = $is_hot = isset($request->is_hot) ? $request->is_hot : null;
        $arrSearch['is_sale'] = $is_sale = isset($request->is_sale) ? $request->is_sale : null;
        $arrSearch['out_of_stock'] = $out_of_stock = isset($request->out_of_stock) ? $request->out_of_stock : null;
        $arrSearch['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';
        
        $query = Product::where('product.status', $status);
        if( $is_hot ){
            $query->where('product.is_hot', $is_hot);
        }
        if( $is_sale ){
            $query->where('product.is_sale', $is_sale);
        }
        if( $parent_id ){
            $query->where('product.parent_id', $parent_id);
        }
        if( $cate_id ){
            $query->where('product.cate_id', $cate_id);
        }
        if( $grand_id ){
            $query->where('product.grand_id', $grand_id);
        }
        if( $out_of_stock ){
            $query->where('product.out_of_stock', $out_of_stock);
        }        
        if( $name != ''){
            $query->where('product.alias', 'LIKE', '%'.$name.'%');           
        }
        if( $code != ''){
            $query->where('product.code', 'LIKE', '%'.$code.'%');           
        }
        $query->join('users', 'users.id', '=', 'product.created_user');
        $query->join('cate_parent', 'cate_parent.id', '=', 'product.parent_id');
        $query->join('cate', 'cate.id', '=', 'product.cate_id');
        //$query->join('grand', 'grand.id', '=', 'product.grand_id');
        $query->orderBy('product.is_hot', 'desc')->orderBy('product.id', 'desc');
        $items = $query->select(['product.*','product.id as product_id', 'display_name' , 'product.created_at as time_created', 'cate_parent.name as cate_parent_name', 'cate.name as cate_name'])
        ->paginate(50);   
        
        if( $parent_id ){
            $cateList = Cate::where('parent_id', $parent_id)->orderBy('display_order', 'desc')->get();
        }else{
            $cateList = (object) [];
        }
        if( $cate_id ){
            $grandList = Grand::where('cate_id', $cate_id)->orderBy('display_order', 'desc')->get();
        }else{
            $grandList = (object) [];
        }

        return view('backend.product.index', compact( 'items', 'arrSearch', 'cateList', 'grandList'));        
    }
   
    public function ajaxGetTienIch(Request $request){
        $district_id = $request->district_id;
        $tienIchLists = Tag::where(['type' => 3])->get();
        return view('backend.product.ajax-get-tien-ich', compact( 'tienIchLists'));   
    }
    public function saveOrderHot(Request $request){
        $data = $request->all();
        if(!empty($data['display_order'])){
            foreach ($data['display_order'] as $id => $display_order) {
                $model = Product::find($id);
                $model->display_order = $display_order;
                $model->save();
            }
        }
        Session::flash('message', 'Cập nhật thứ tự tin HOT thành công');

        return redirect()->route('product.index', ['is_hot' => 1]);
    }
    public function ajaxSearch(Request $request){    
        $search_type = $request->search_type;        
        $arrSearch['cate_id'] = $cate_id = isset($request->cate_id) ? $request->cate_id : -1;
        $arrSearch['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';
        
        $query = Product::whereRaw('1');        
        
        if( $cate_id ){
            $query->where('product.cate_id', $cate_id);
        }
        if( $name != ''){
            $query->where('product.title', 'LIKE', '%'.$name.'%');
            $query->orWhere('name_extend', 'LIKE', '%'.$name.'%');
        }
        $query->join('users', 'users.id', '=', 'product.created_user');
        $query->join('estate_type', 'estate_type.id', '=', 'product.type_id');
        $query->join('cate', 'cate.id', '=', 'product.cate_id');
        $query->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id');        
        $query->orderBy('product.id', 'desc');
        $items = $query->select(['product_img.image_url','product.*','product.id as product_id', 'fullname' , 'product.created_at as time_created', 'users.fullname', 'estate_type.name as ten_loai', 'cate.name as ten_cate'])
        ->paginate(1000);

        $estateTypeArr = CateParent::all();  
        

        return view('backend.product.content-search', compact( 'items', 'arrSearch', 'estateTypeArr',  'search_type'));
    }

   
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        $tagList = Tag::where('type', 1)->get();
        
        $cateList = Cate::whereRaw('1=2')->get();
        $parent_id = $request->parent_id ? $request->parent_id : null;
        $cate_id = $request->cate_id ? $request->cate_id : null;
        $grand_id = $request->grand_id ? $request->grand_id : null;
        
        if( $parent_id ){
            $cateList = Cate::where('parent_id', $parent_id)->orderBy('display_order', 'desc')->get();
        }else{
            $cateList = (object) [];
        } 

        if( $cate_id ){
            $grandList = Grand::where('cate_id', $cate_id)->orderBy('display_order', 'desc')->get();
        }else{
            $grandList = (object) [];
        }        
        
        return view('backend.product.create', compact('cateList', 'parent_id', 'cate_id', 'tagList', 'grandList', 'grand_id'));
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
            'parent_id' => 'required',
            'cate_id' => 'required',            
            'code' => 'required',              
            'name' => 'required',
            'slug' => 'required',            
            'price' => 'required'
        ],
        [   
            'parent_id.required' => 'Bạn chưa chọn loại sản phẩm',
            'cate_id.required' => 'Bạn chưa chọn danh mục cha',            
            'code.required' => 'Bạn chưa nhập mã sản phẩm',
            'name.required' => 'Bạn chưa nhập tên sản phẩm',
            'slug.required' => 'Bạn chưa nhập slug',
            'price.required' => 'Bạn chưa nhập giá'
        ]);
           
        $dataArr['slug'] = str_replace(".", "-", $dataArr['slug']);
        $dataArr['slug'] = str_replace("(", "-", $dataArr['slug']);
        $dataArr['slug'] = str_replace(")", "", $dataArr['slug']);
        $dataArr['alias'] = Helper::stripUnicode($dataArr['name']);
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;         
        $dataArr['out_of_stock'] = isset($dataArr['out_of_stock']) ? 1 : 0;
        $dataArr['status'] = 1;
        $dataArr['created_user'] = Auth::user()->id;
        $dataArr['updated_user'] = Auth::user()->id;              

        $rs = Product::create($dataArr);
        $product_id = $rs->id;       
        
        $this->storeMeta($product_id, 0, $dataArr);
        $this->processRelation($dataArr, $product_id);

        // store Rating
        for($i = 1; $i <= 5 ; $i++ ){
            $amount = $i == 5 ? 1 : 0;
            Rating::create(['score' => $i, 'object_id' => $product_id, 'object_type' => 1, 'amount' => $amount]);
        }

        Session::flash('message', 'Tạo mới thành công');

        return redirect()->route('product.index', ['parent_id' => $dataArr['parent_id'], 'cate_id' => $dataArr['cate_id']]);
    }
    public function storeChange(Request $request)
    {
        $dataArr = $request->all();
       // var_dump("<pre>", $dataArr);die;        
        if(!empty($dataArr['parent_id_select'])){
            foreach($dataArr['parent_id_select'] as $cate_id){
                $cateDetail = Cate::find($cate_id);
                //echo "<pre>";
               // print_r($cateDetail);die;
                $grandDetail = Grand::create([
                    'cate_id' => $dataArr['cate_id'],
                    'name' => $cateDetail->name,
                    'slug' => $cateDetail->slug,
                    'description' => $cateDetail->description,
                    'image_url' => $cateDetail->image_url,
                    'parent_id' => $cateDetail->parent_id,
                    'display_order' => $cateDetail->display_order,
                    'meta_id' => $cateDetail->meta_id,
                    'is_hot' => $cateDetail->is_hot,
                    'is_widget' => $cateDetail->is_widget,
                    'status' => $cateDetail->status,
                    'created_user' => $cateDetail->created_user,
                    'updated_user' => $cateDetail->updated_user,
                    ]);
                $grand_id = $grandDetail->id;

                $productList = Product::where('cate_id', $cate_id)->get();
                foreach($productList as $pro){
                    $pro->grand_id = $grand_id;
                    $pro->cate_id = $dataArr['cate_id'];
                    $pro->save();
                }
                $cateDetail->delete();
            }
        }
         Session::flash('message', 'Cập nhật thành công');
        return redirect()->route('product.change', ['parent_id' => $dataArr['parent_id'], 'cate_id' => $dataArr['cate_id']]);
    }
    private function processRelation($dataArr, $object_id, $type = 'add'){
    
        if( $type == 'edit'){          
            TagObjects::deleteTags( $object_id, 1);
        }
        // xu ly tags
        if( !empty( $dataArr['tags'] ) && $object_id ){
            foreach ($dataArr['tags'] as $tag_id) {
                TagObjects::create(['object_id' => $object_id, 'tag_id' => $tag_id, 'type' => 1]);
            }
        }      
      
    }
    public function storeMeta( $id, $meta_id, $dataArr ){
       
        $arrData = ['title' => $dataArr['meta_title'], 'description' => $dataArr['meta_description'], 'keywords'=> $dataArr['meta_keywords'], 'custom_text' => $dataArr['custom_text'], 'updated_user' => Auth::user()->id];
        if( $meta_id == 0){
            $arrData['created_user'] = Auth::user()->id;            
            $rs = MetaData::create( $arrData );
            $meta_id = $rs->id;            
            $modelSp = Product::find( $id );
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
        $tagList = Tag::where('type', 1)->get();
        $hinhArr = (object) [];
        $detail = Product::find($id);  
        
        $cateList = Cate::where('parent_id', $detail->parent_id)->get();
        $grandList = Grand::where('cate_id', $detail->cate_id)->get();

        $meta = (object) [];
        if ( $detail->meta_id > 0){
            $meta = MetaData::find( $detail->meta_id );
        }               
        
        $tagSelected = Product::productTag($id);

        return view('backend.product.edit', compact( 'detail', 'meta', 'cateList', 'tagList', 'tagSelected', 'grandList'));
    }
    public function ajaxDetail(Request $request)
    {       
        $id = $request->id;
        $detail = Product::find($id);
        return view('backend.product.ajax-detail', compact( 'detail' ));
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
            'parent_id' => 'required',
            'cate_id' => 'required',             
            'code' => 'required',              
            'name' => 'required',
            'slug' => 'required',            
            'price' => 'required'
        ],
        [   
            'parent_id.required' => 'Bạn chưa chọn loại sản phẩm',
            'cate_id.required' => 'Bạn chưa chọn danh mục cha',            
            'code.required' => 'Bạn chưa nhập mã sản phẩm',
            'name.required' => 'Bạn chưa nhập tên sản phẩm',
            'slug.required' => 'Bạn chưa nhập slug',
            'price.required' => 'Bạn chưa nhập giá'
        ]);
           
        $dataArr['slug'] = str_replace(".", "-", $dataArr['slug']);
        $dataArr['slug'] = str_replace("(", "-", $dataArr['slug']);
        $dataArr['slug'] = str_replace(")", "", $dataArr['slug']);
        $dataArr['alias'] = Helper::stripUnicode($dataArr['name']);
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;    
        $dataArr['is_sale'] = isset($dataArr['is_sale']) ? 1 : 0;     
        $dataArr['out_of_stock'] = isset($dataArr['out_of_stock']) ? 1 : 0;             
        $dataArr['updated_user'] = Auth::user()->id;        
        
        $model = Product::find($dataArr['id']);

        $model->update($dataArr);
        
        $product_id = $dataArr['id'];
        
        $this->storeMeta( $product_id, $dataArr['meta_id'], $dataArr);       
        $this->processRelation($dataArr, $product_id, 'edit');

        Session::flash('message', 'Cập nhật thành công');

        return redirect()->route('product.edit', $product_id);
        
    }
    public function ajaxSaveInfo(Request $request){
        
        $dataArr = $request->all();

        $dataArr['alias'] = Helper::stripUnicode($dataArr['name']);
        
        $dataArr['updated_user'] = Auth::user()->id;
        
        $model = Product::find($dataArr['id']);

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
        $model = Product::find($id);        
        $model->delete();
        Rating::where('object_id', $id)->where('object_type', 1)->delete();
        // redirect
        Session::flash('message', 'Xóa thành công');
        
        return redirect(URL::previous());
        
    }
}
