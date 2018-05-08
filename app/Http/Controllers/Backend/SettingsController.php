<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Product;
use App\Models\Settings;
use App\Models\Text;

use File, Session, DB, Auth;

class SettingsController  extends Controller
{
    public function index(Request $request)
    {   
                  
        if(Auth::user()->role < 3){
            return redirect()->route('product.index');
        }
        $settingArr = Helper::setting();

        return view('backend.settings.index', compact( 'settingArr'));
    }
    public function saveContent(Request $request){
        $id = $request->id;
        $content = $request->content;
        $md = Text::find($id);
        $md->content = $content;
        $md->save();
    }
     public function noti(Request $request)
    {           
        if(Auth::user()->role < 3){
            return redirect()->route('product.index');
        }   
        $settingArr = Helper::setting();

        return view('backend.settings.noti', compact( 'settingArr'));
    }
    public function dashboard(Request $request)
    {              
        if(Auth::user()->role < 3){
            return redirect()->route('product.index');
        }
        $settingArr = Helper::setting();
        $query = Product::where('product.status', 2);
        
        //$query->join('users', 'users.id', '=', 'product.created_user');
        $query->join('city', 'city.id', '=', 'product.city_id');        
        $query->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id'); 
        $query->join('estate_type', 'product.estate_type_id', '=','estate_type.id'); 
        $query->orderBy('product.id', 'desc');   
        $kyguiList = $query->select(['product_img.image_url as image_urls','product.*', 'estate_type.slug as slug_loai'])->get();


        return view('backend.product.index', compact( 'settingArr', 'kyguiList'));
    }
    public function storeNoti(Request $request){

        $dataArr = $request->all();

        $dataArr['updated_user'] = Auth::user()->id;

        unset($dataArr['_token']);       

        foreach( $dataArr as $key => $value ){
            $data['value'] = $value;
            Settings::where( 'name' , $key)->update($data);
        }

        Session::flash('message', 'Cập nhật thành công.');

        return redirect()->route('settings.noti');
    }
    public function update(Request $request){

        if(Auth::user()->role < 3){
            return redirect()->route('product.index');
        }
    	$dataArr = $request->all();

    	$this->validate($request,[            
            'site_name' => 'required',            
            'site_title' => 'required',            
            'site_description' => 'required',            
            'site_keywords' => 'required',                                    
        ],
        [            
            'site_name.required' => 'Bạn chưa nhập tên site',            
            'site_title.required' => 'Bạn chưa nhập meta title',
            'site_description.required' => 'Bạn chưa nhập meta desciption',
            'site_keywords.unique' => 'Bạn chưa nhập meta keywords.'
        ]);  
        $dataArr['updated_user'] = Auth::user()->id;

        unset($dataArr['_token']);
        unset($dataArr['logo_name']);
        unset($dataArr['favicon_name']);
        unset($dataArr['banner_name']);

    	foreach( $dataArr as $key => $value ){
    		$data['value'] = $value;
    		Settings::where( 'name' , $key)->update($data);
    	}

    	Session::flash('message', 'Cập nhật thành công.');

    	return redirect()->route('settings.index');
    }
}
