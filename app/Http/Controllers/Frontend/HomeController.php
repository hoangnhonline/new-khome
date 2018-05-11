<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Folder;
use App\Models\Chapter;
use App\Models\Page;
use App\Models\Author;
use App\Models\Settings;

use Helper, File, Session, Auth, Hash, Response, URL;

class HomeController extends Controller
{
    public function __construct(){
    }   
    public function getChild(Request $request){
        $module = $request->mod;
        $id = $request->id;
        $column = $request->col;
        return Helper::getChild($module, $column, $id);
    }     
    public function index(Request $request)
    {   
        $settingArr = Helper::setting();     
        
        $seo = $settingArr;
        $seo['title'] = $settingArr['site_title'];
        $seo['description'] = $settingArr['site_description'];
        $seo['keywords'] = $settingArr['site_keywords'];
        $socialImage = $settingArr['banner'];

        $bookList = Book::where('folder_id', 1)->where('status', 1)->orderBy('display_order', 'asc')->get();
        $hotList = Book::where('status', 1)->orderBy('id', 'desc')->limit(5)->get();
        return view('frontend.index', compact('socialImage', 'seo', 'bookList', 'hotList'));

    }
    public function folder(Request $request){
        $folder_id = $request->id;
        $folderDetail = Folder::find($folder_id);
        if(!$folderDetail){
            return redirect()->route('home');
        }
        $seo['title'] =  $seo['description'] = $seo['keywords'] = $folderDetail->name;         
        $bookList = Book::where(['folder_id' => $folder_id, 'status' => 1])->get();
        return view('frontend.folder', compact('socialImage', 'seo', 'bookList', 'folder_id'));
    }
    public function book(Request $request){
        $book_id = $request->id;
        $bookDetail = Book::find($book_id);
        if(!$bookDetail){
            return redirect()->route('home');
        }
        $seo['title'] =  $seo['description'] = $seo['keywords'] = $bookDetail->name;         
        $chapterList = Chapter::where(['book_id' => $book_id, 'status' => 1])->get();
        $folder_id = $bookDetail->folder_id;
        $bookList = Book::where(['folder_id' => $folder_id, 'status' => 1])->get();
        return view('frontend.book', compact('socialImage', 'seo', 'bookDetail', 'chapterList', 'folder_id', 'bookList', 'book_id'));
    }
    public function chapter(Request $request){
        $chapter_id = $request->id;
        $chapterDetail =Chapter::find($chapter_id);
        if(!$chapterDetail){
            return redirect()->route('home');
        }
        $seo['title'] =  $seo['description'] = $seo['keywords'] = $chapterDetail->name;         
        $pageList = Page::where(['chapter_id' => $chapter_id, 'status' => 1])->get();
        $folder_id = $chapterDetail->folder_id;
        $book_id = $chapterDetail->book_id;
        $chapterList = Chapter::where(['book_id' => $book_id, 'status' => 1])->get();
        $bookList = Book::where(['folder_id' => $folder_id, 'status' => 1])->get();
        $url = url()->current();        
        return view('frontend.chapter', compact('socialImage', 'seo', 'bookDetail', 'chapterList', 'folder_id', 'bookList', 'book_id', 'pageList', 'chapter_id'));
    }
    public function pages(Request $request){
        $slug = $request->slug;

        $detailPage = Pages::where('slug', $slug)->first();
         
        if(!$detailPage){
            return redirect()->route('home');
        }
        $seo['title'] = $detailPage->meta_title ? $detailPage->meta_title : $detailPage->title;
        $seo['description'] = $detailPage->meta_description ? $detailPage->meta_description : $detailPage->title;
        $seo['keywords'] = $detailPage->meta_keywords ? $detailPage->meta_keywords : $detailPage->title;     
        return view('frontend.pages.index', compact('detailPage', 'seo', 'slug'));    
    }

    
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function search(Request $request)
    {
        $tu_khoa = $request->keyword;        
        $tu_khoa_find = Helper::stripUnicode($tu_khoa);        
        $query = Product::where('product.alias', 'LIKE', '%'.$tu_khoa_find.'%')->orWhere('product.code', 'LIKE', '%'.$tu_khoa_find.'%')             
                    ->select('product.*')                                                  
                    ->orderBy('product.id', 'desc');
                   $productList = $query->paginate(15);
        $seo['title'] = $seo['description'] =$seo['keywords'] = "Tìm kiếm sản phẩm theo từ khóa '".$tu_khoa."'";
       
        return view('frontend.cate.search', compact('productList', 'tu_khoa', 'seo', 'parent_id'));
    }    

}
