<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Product;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;
use App\Models\Project;
use App\Models\EstateType;
use App\Models\MetaData;
use App\Models\Pages;
use Helper, File, Session, Auth;
use Mail;

class ProductController extends Controller
{
    public function cate(Request $request)
    {
         $productArr = [];
        $slug = $request->slug;
        $rs = EstateType::where('slug', $slug)->first();        
        if($rs){//danh muc cha
            $estate_type_id = $rs->id;
            
            $query = Product::where('estate_type_id', $estate_type_id)               
                ->where('product.status', 1)
                ->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id') 
                ->join('estate_type', 'estate_type.id', '=','product.estate_type_id')                
                ->select('product_img.image_url as image_urls', 'product.*', 'estate_type.slug as slug_loai')              
                ->where('product_img.image_url', '<>', '')
                ->orderBy('product.is_hot', 'desc')
                ->orderBy('product.cart_status', 'asc')
                ->orderBy('product.id', 'desc');
                $productList  = $query->paginate(10);
                $productArr = $productList->toArray();
            
            if( $rs->meta_id > 0){
               $seo = MetaData::find( $rs->meta_id )->toArray();
            }else{
                $seo['title'] = $seo['description'] = $seo['keywords'] = $rs->name;
            }            
            $type = $rs->type;                                     
            return view('frontend.cate.parent', compact('productList','productArr', 'rs', 'hoverInfo', 'socialImage', 'seo', 'type', 'estate_type_id'));
        }else{
            $detailPage = Pages::where('slug', $slug)->first();
            if(!$detailPage){
                return redirect()->route('home');
            }
            $seo['title'] = $detailPage->meta_title ? $detailPage->meta_title : $detailPage->title;
            $seo['description'] = $detailPage->meta_description ? $detailPage->meta_description : $detailPage->title;
            $seo['keywords'] = $detailPage->meta_keywords ? $detailPage->meta_keywords : $detailPage->title;           
            return view('frontend.pages.index', compact('detailPage', 'seo'));    
        }
    }
    public function ban(Request $request)
    {
        $productArr = [];

        $query = Product::where('product.type', 1);
        
            $query->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id') 
            ->join('estate_type', 'estate_type.id', '=','product.estate_type_id')                
            ->select('product_img.image_url as image_urls', 'product.*', 'estate_type.slug as slug_loai')              
            ->where('product_img.image_url', '<>', '')
            ->orderBy('product.is_hot', 'desc')
            ->orderBy('product.cart_status', 'asc')
            ->orderBy('product.id', 'desc');
            $productList  = $query->paginate(10);
            $productArr = $productList->toArray();
            
            
            $name = $seo['title'] = $seo['description'] = $seo['keywords'] = 'Nhà đất bán';
             $type = 1;
             $seo['custom_text'] = "";
            return view('frontend.cate.type', compact('productList','productArr', 'socialImage', 'seo', 'name', 'type'));
        
    }
    public function choThue(Request $request)
    {
        $productArr = [];

        $query = Product::where('product.type', 2);
        
        $query->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id') 
        ->join('estate_type', 'estate_type.id', '=','product.estate_type_id')                
        ->select('product_img.image_url as image_urls', 'product.*', 'estate_type.slug as slug_loai')              
        ->where('product_img.image_url', '<>', '')
        ->orderBy('product.is_hot', 'desc')
        ->orderBy('product.cart_status', 'asc')
        ->orderBy('product.id', 'desc');
        $productList  = $query->paginate(10);
        $productArr = $productList->toArray();
        
        
        $name = $seo['title'] = $seo['description'] = $seo['keywords'] = 'Nhà đất cho thuê';
        $type = 2;
        $seo['custom_text'] = "";
        return view('frontend.cate.type', compact('productList','productArr', 'socialImage', 'seo', 'name', 'type'));
        
    }
    public function search(Request $request)
    {
        $productArr = [];
       
            $estate_type_id = $request->estate_type_id;
            $type = $request->type;
            $district_id = $request->district_id;
            $city_id = $request->city_id;
            $ward_id = $request->ward_id;
            $project_id = $request->project_id;
            $price_id = $request->price_id;
            $area_id = $request->area_id;
            $street_id = $request->street_id;
            $no_room = $request->no_room;
            $direction_id = $request->direction_id;

            $query = Product::where('estate_type_id', $estate_type_id);
            if($city_id){
                $query->where('city_id', $city_id);
            }
            if($district_id){
                $query->where('district_id', $district_id);
            }
            if($ward_id){
                $query->where('ward_id', $ward_id);
            }
            if($project_id){
                $query->where('project_id', $project_id);
            }
            if($price_id){
                $query->where('price_id', $price_id);
            }
            if($area_id){
                $query->where('area_id', $area_id);
            }
            if($street_id){
                $query->where('street_id', $street_id);
            }
            if($direction_id){
                $query->where('direction_id', $direction_id);
            }
                $query->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id') 
                ->join('estate_type', 'estate_type.id', '=','product.estate_type_id')                
                ->select('product_img.image_url as image_urls', 'product.*', 'estate_type.slug as slug_loai')              
                ->where('product_img.image_url', '<>', '')
                ->orderBy('product.is_hot', 'desc')
                ->orderBy('product.cart_status', 'asc')
                ->orderBy('product.id', 'desc');
                $productList  = $query->paginate(10);
                $productArr = $productList->toArray();
            
            
            $seo['title'] = $seo['description'] = $seo['keywords'] = 'Tìm kiếm';
            
            return view('frontend.cate.search', compact('productList','productArr', 'socialImage', 'seo',
            'type',
            'estate_type_id',
            'street_id',
            'ward_id',
            'city_id',
            'district_id',
            'no_room',
            'direction_id',
            'area_id',
            'project_id',
            'price_id'
                ));
        
    }       

     public function newsDetail(Request $request)
    {     
        $id = $request->id;

        $detail = Articles::where( 'id', $id )
                ->select('id', 'title', 'slug', 'description', 'image_url', 'content', 'meta_id', 'created_at', 'cate_id')
                ->first();
        $is_km = $is_news = $is_kn = 0;
        if( $detail ){           

            $title = trim($detail->meta_title) ? $detail->meta_title : $detail->title;

            $hotArr = Articles::where( ['cate_id' => 1, 'is_hot' => 1] )->where('id', '<>', $id)->orderBy('id', 'desc')->limit(5)->get();
            $otherArr = Articles::where( ['cate_id' => 1] )->where('id', '<>', $id)->orderBy('id', 'desc')->limit(4)->get();
            $seo['title'] = $detail->meta_title ? $detail->meta_title : $detail->title;
            $seo['description'] = $detail->meta_description ? $detail->meta_description : $detail->title;
            $seo['keywords'] = $detail->meta_keywords ? $detail->meta_keywords : $detail->title;
            $socialImage = $detail->image_url; 
            $is_km = $detail->cate_id == 2 ? 1 : 0;
            $is_news = $detail->cate_id == 1 ? 1 : 0;
            $is_kn = $detail->cate_id == 4 ? 1 : 0;
            return view('frontend.news.news-detail', compact('title',  'hotArr', 'detail', 'otherArr', 'seo', 'socialImage', 'is_km', 'is_news', 'is_kn'));
        }else{
            return view('erros.404');
        }
    }
}

