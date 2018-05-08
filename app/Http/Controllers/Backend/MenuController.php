<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\ArticlesCate;
use App\Models\Pages;
use App\Models\Menu;

use DB, Session;
class MenuController extends Controller
{    
    public function index(Request $request){
        //$dirs = array_filter(glob(public_path()."/uploads/*"), 'is_dir');
        //print_r( $dirs);
        $menu_id = $request->menu_id ? $request->menu_id : 1;
        $menuLists = Menu::where('parent_id', 0)->where('menu_id', $menu_id)->orderBy('display_order')->get();
        
        return view('backend.menu.index', compact('menuLists', 'menu_id'));
    }
    public function loadCreate(Request $request){
        $articlesCateList = ArticlesCate::where('status', 1)->where('type', 1)->orderBy('display_order', 'asc')->get();
        $pageList = Pages::where('status', 1)->get();
        $parent_id = $request->parent_id ? $request->parent_id : 0;
        $menu_id = $request->menu_id ? $request->menu_id : 1;
        return view('backend.menu.ajax-create', compact('menuList', 'articlesCateList', 'menu_id','pageList', 'parent_id'));   
    }
    public function getSlug(Request $request){
    	$strReturn = '';
    	if( $request->ajax() ){
    		$str = $request->str;
    		if( $str ){
    			$strReturn = str_slug( $str );
    		}
    	}
    	return response()->json( ['str' => $strReturn] );
    }
    public function setupMenu(Request $request){        
        $articlesCateList = ArticlesCate::where('status', 1)->orderBy('display_order', 'asc')->get();
        $pageList = Pages::where('status', 1)->get();
        return view('backend.menu.index', compact( 'landingList', 'articlesCateList', 'pageList'));
    }
    public function renderMenu(Request $request){        
        $dataArr = $request->all();       
        return view('backend.menu.render-menu', compact( 'dataArr' ));   
    }
    public function store(Request $request){
        $data = $request->all();        
        $data['slug'] = str_slug($data['title']);
        $data['title_attr'] = str_slug($data['title']);
        $data['display_order'] = Helper::getNextOrder('menu', ['parent_id' => $data['parent_id'], 'menu_id' => $data['menu_id']]);
        Menu::create($data);
        Session::flash('message', 'Cập nhật menu thành công.');

        return redirect()->route('menu.index', ['menu_id' => $data['menu_id']]);
    }
    public function storeOrder(Request $request){
        $idArr = $request->id;
        $display_orderArr = $request->display_order;
        foreach($idArr as $key => $id){
            $model = Menu::find($id);
            $model->display_order = $display_orderArr[$key];
            $model->save();
        }
        Session::flash('message', 'Cập nhật thứ tự thành công.');

        return redirect()->route('menu.index', ['menu_id' => $request->menu_id]);
    }
    public function destroy($id)
    {
        // delete
        $model = Menu::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('menu.index');
    }
}
