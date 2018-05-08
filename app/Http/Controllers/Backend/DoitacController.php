<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Doitac;
use Helper, File, Session, Auth, Image, DB;

class DoitacController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {  
        $query = Doitac::where('status', 1);
       
        $items = $query->orderBy('display_order')->get();        
        return view('backend.doitac.index', compact( 'items'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {      
                    
        return view('backend.doitac.create');
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
            'name' => 'required',
        ],
        [
            'name.required' => 'Bạn chưa nhập tên',          
        ]);
        
        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;
        
      
        $dataArr['display_order'] = Helper::getNextOrder('doitac');
         
        $rs = Doitac::create($dataArr);    

        Session::flash('message', 'Tạo mới thành công');

        return redirect()->route('doitac.index');
    }

   
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
          
        $detail = Doitac::find($id); 
       
        return view('backend.doitac.edit', compact( 'detail'));
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
            
            'name' => 'required',                   
            
        ],
        [
            'name.required' => 'Bạn chưa nhập tên',
            
        ]);

        $model = Doitac::find($dataArr['id']);

        $dataArr['updated_user'] = Auth::user()->id;
        
    
        $model->update($dataArr);
        
        Session::flash('message', 'Cập nhật thành công');

        return redirect()->route('doitac.edit', $dataArr['id']);
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
        $model = Doitac::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('doitac.index',[$model->parent_id]);
    }
}
