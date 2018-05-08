<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\ArticlesCate;
use App\Models\Pages;
use App\Models\HotCate;

use DB, Session;
class HotCateController extends Controller
{    
    public function index(Request $request){
        
        $items = HotCate::orderBy('display_order')->get();
        
        return view('backend.hot-cate.index', compact('items'));
    }
    public function loadCreate(Request $request){
        return view('backend.hot-cate.ajax-create');   
    }   
    
    public function store(Request $request){
        $data = $request->all();        
        $data['display_order'] = Helper::getNextOrder('hot_cate');
        HotCate::create($data);
        Session::flash('message', 'Cập nhật thành công.');

        return redirect()->route('hot-cate.index');
    }
    public function storeOrder(Request $request){
        $idArr = $request->id;
        $display_orderArr = $request->display_order;
        foreach($idArr as $key => $id){
            $model = HotCate::find($id);
            $model->display_order = $display_orderArr[$key];
            $model->save();
        }
        Session::flash('message', 'Cập nhật thứ tự thành công.');

        return redirect()->route('hot-cate.index');
    }
    public function destroy($id)
    {
        // delete
        $model = HotCate::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('hot-cate.index');
    }
}
