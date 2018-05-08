<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\City;

use Helper, Session, Auth;

class BranchController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {           
        $name = isset($request->name) && $request->name != '' ? $request->name : '';
        
        $query = Branch::where('status', 1);
       
        if( $name != ''){
            $query->where('alias', 'LIKE', '%'.$name.'%');
        }

        $items = $query->orderBy('display_order')->paginate(20);
       
        
        return view('backend.branch.index', compact( 'items', 'name' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {   
        $cityList = City::all();  
        return view('backend.branch.create', compact('cityList'));
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
            'city_id' => 'required',
            'address' => 'required',
            'district_id' => 'required',
            'ward_id' => 'required',
        ],
        [          
            'name.required' => 'Bạn chưa nhập tên',
            'address.required' => 'Bạn chưa nhập địa chỉ',
            'city_id.required' => 'Bạn chưa nhập tên',
            'district_id.required' => 'Bạn chưa nhập tên',
            'ward_id.required' => 'Bạn chưa nhập tên',           
           
        ]);   
        
        $dataArr['alias'] = Helper::stripUnicode($dataArr['name']);      
        
        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;

        $dataArr['display_order'] = Helper::getNextOrder('branch');

        $rs = Branch::create($dataArr);

        Session::flash('message', 'Tạo mới thành công');

        return redirect()->route('branch.index');
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
        $cityList = City::all();  
        $detail = Branch::find($id);
        if( Auth::user()->role < 3 ){
            if($detail->created_user != Auth::user()->id){
                return redirect()->route('product.index');
            }
        }       

        return view('backend.branch.edit', compact('detail', 'cityList'));
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
            'city_id' => 'required',
            'address' => 'required',
            'district_id' => 'required',
            'ward_id' => 'required',
        ],
        [          
            'name.required' => 'Bạn chưa nhập tên',
            'address.required' => 'Bạn chưa nhập địa chỉ',
            'city_id.required' => 'Bạn chưa nhập tên',
            'district_id.required' => 'Bạn chưa nhập tên',
            'ward_id.required' => 'Bạn chưa nhập tên',           
           
        ]);        
        
        $dataArr['alias'] = Helper::stripUnicode($dataArr['name']);
       
        $dataArr['updated_user'] = Auth::user()->id;
        
        $model = Branch::find($dataArr['id']);

        $model->update($dataArr);        
  
        Session::flash('message', 'Cập nhật thành công');        

        return redirect()->route('branch.edit', $dataArr['id']);
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
        $model = Branch::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('branch.index');
    }
}
