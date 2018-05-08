<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cate;
use App\Models\CateParent;
use App\Models\Product;
use App\Models\MetaData;
use App\Models\ArticlesCate;
use App\Models\Articles;
use App\Models\Grand;
use Helper;

class CateController extends Controller
{

    public function __construct(){
        
    }
      
    public function cateParent(Request $request){
        
        $productArr = [];
        $cateList = (object) [];
        
        $slugCateParent = $request->slugCateParent;
        
        if(!$slugCateParent){
            return redirect()->route('home');       
        }

        $parentDetail = CateParent::where('slug', $slugCateParent)->first();

        if($parentDetail){
            $parent_id = $parentDetail->id;
            $cateList = Cate::getList($parent_id);
            
            if($cateList){
                foreach($cateList as $cate){
                    $productArr[$cate->id] = Product::getList( ['cate_id' => $cate->id, 'limit' => 20] );
                }
            }       
            if( $parentDetail->meta_id > 0){
               $seo = MetaData::find( $parentDetail->meta_id )->toArray();
            }else{
                $seo['title'] = $seo['description'] = $seo['keywords'] = $parentDetail->name;
            }  
            
            $hotProductList = Product::getList(['is_hot' => 1, 'parent_id' => $parent_id, 'limit' => 20]);
            return view('frontend.cate.parent', compact('parent_id', 'parentDetail', 'cateList', 'productArr', 'seo', 'hotProductList'));

        }else{
            $cateArr = [];
       
            $cateDetail = ArticlesCate::where('slug' , $slugCateParent)->first();
            if(!$cateDetail){
                return redirect()->route('home');
            }
            $title = trim($cateDetail->meta_title) ? $cateDetail->meta_title : $cateDetail->name;
            $settingArr = Helper::setting();
            $articlesArr = Articles::where('cate_id', $cateDetail->id)->where('status', 1)->orderBy('is_hot', 'desc')->orderBy('id', 'desc')->paginate($settingArr['articles_per_page']);

            $hotArr = Articles::where( ['cate_id' => $cateDetail->id, 'is_hot' => 1] )->orderBy('id', 'desc')->limit(5)->get();
            $seo['title'] = $cateDetail->meta_title ? $cateDetail->meta_title : $cateDetail->title;
            $seo['description'] = $cateDetail->meta_description ? $cateDetail->meta_description : $cateDetail->title;
            $seo['keywords'] = $cateDetail->meta_keywords ? $cateDetail->meta_keywords : $cateDetail->title;
            $socialImage = $cateDetail->image_url; 
                 
            return view('frontend.news.index', compact('title', 'hotArr', 'articlesArr', 'cateDetail', 'seo', 'socialImage'));                
        }
        
    }
    public function cateChild(Request $request){
       
        $slugCateChild = $request->slugCateChild;
        
        if(!$slugCateChild){
            return redirect()->route('home');
        }
        $cateDetail = Cate::where('slug', $slugCateChild)->first();

        if($cateDetail){
            $cate_id = $cateDetail->id;
            
            $settingArr = Helper::setting();
            
            $productList = Product::getList( ['cate_id' => $cate_id, 'pagination' => $settingArr['product_per_page']] );
            
            if( $cateDetail->meta_id > 0){
               $seo = MetaData::find( $cateDetail->meta_id )->toArray();
            }else{
                $seo['title'] = $seo['description'] = $seo['keywords'] = $cateDetail->name;
            }  
            $page = $request->page ? $request->page : 1;    
            $hotProductList = Product::getList(['is_hot' => 1, 'cate_id' => $cate_id, 'limit' => 20]);    
            return view('frontend.cate.child', compact('parent_id', 'cateDetail', 'productList', 'seo', 'page', 'hotProductList'));
            
        }else{
            return redirect()->route('home');   
        }
    }  
    public function grand(Request $request){
       
        $slugCateChild = $request->slugCateChild;
        $slugGrand = $request->slugGrand;
        
        if(!$slugCateChild || !$slugGrand){
            return redirect()->route('home');
        }
        $cateDetail = Cate::where('slug', $slugCateChild)->first();
        $grandDetail = Grand::where('slug', $slugGrand)->first();
        if($grandDetail){
            $cate_id = $cateDetail->id;
            $grand_id = $grandDetail->id;            
            $settingArr = Helper::setting();
            
            $productList = Product::getList( ['grand_id' => $grand_id,'pagination' => $settingArr['product_per_page']] );
            
            if( $grandDetail->meta_id > 0){
               $seo = MetaData::find( $grandDetail->meta_id )->toArray();
            }else{
                $seo['title'] = $seo['description'] = $seo['keywords'] = $grandDetail->name;
            }  
            $page = $request->page ? $request->page : 1;    
            $hotProductList = Product::getList(['is_hot' => 1, 'cate_id' => $cate_id, 'limit' => 20]);    
            return view('frontend.cate.grand', compact('parent_id', 'cateDetail', 'productList', 'seo', 'page', 'hotProductList', 'grandDetail'));
            
        }else{
            return redirect()->route('home');   
        }
    }      
    
}
