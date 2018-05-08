<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Services;

use Helper, Session, Auth;

class ServicesController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {           
        $title = isset($request->title) && $request->title != '' ? $request->title : '';
        
        $query = Services::where('status', 1);
       
        if( $title != ''){
            $query->where('alias', 'LIKE', '%'.$title.'%');
        }

        $items = $query->orderBy('display_order')->paginate(20);
       
        
        return view('backend.services.index', compact( 'items', 'title' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {   
        return view('backend.services.create');
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
            'title' => 'required',            
            'slug' => 'required|unique:services',
        ],
        [          
            'title.required' => 'Bạn chưa nhập tên',
            'slug.required' => 'Bạn chưa nhập slug',
            'slug.unique' => 'Slug đã được sử dụng.'
        ]);   
        
        $dataArr['alias'] = Helper::stripUnicode($dataArr['title']);      
        
        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;

        $dataArr['display_order'] = Helper::getNextOrder('services');

        $rs = Services::create($dataArr);

        Session::flash('message', 'Tạo mới thành công');

        return redirect()->route('services.index');
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

        $detail = Services::find($id);
        if( Auth::user()->role < 3 ){
            if($detail->created_user != Auth::user()->id){
                return redirect()->route('product.index');
            }
        }       

        return view('backend.services.edit', compact('detail'));
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
            'title' => 'required',            
            'slug' => 'required|unique:services,slug,'.$dataArr['id'],
        ],
        [          
            'title.required' => 'Bạn chưa nhập tên',
            'slug.required' => 'Bạn chưa nhập slug',
            'slug.unique' => 'Slug đã được sử dụng.'
        ]);       
        
        $dataArr['alias'] = Helper::stripUnicode($dataArr['title']);
       
        $dataArr['updated_user'] = Auth::user()->id;
        
        $model = Services::find($dataArr['id']);

        $model->update($dataArr);        
  
        Session::flash('message', 'Cập nhật thành công');        

        return redirect()->route('services.edit', $dataArr['id']);
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
        $model = Services::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('services.index');
    }
}
