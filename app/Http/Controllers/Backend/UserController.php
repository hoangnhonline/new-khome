<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Backend\Users;
use Helper, File, Session, Hash, Auth;

class UserController extends Controller
{    

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function loginForm()
    {        
        if(Auth::check()){
            if(Auth::user()->id != 5){
                return redirect()->route('book.index');    
            }else{
                return redirect()->route('orders.index');    
            }
            
        } 
        return view('backend.login');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  Request  $request
    * @return Response
    */
    public function checkLogin(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ],
        [
            'email.required' => 'Please input email',
            'password.required' => 'Please input password'
        ]);
        $dataArr = [
            'email' => $request->email,
            'password' => $request->password            
        ];
        if (Auth::validate($dataArr)) {
            $dataArr['status'] = 1;
            if (Auth::attempt($dataArr)) {                    
                if(Auth::user()->id != 5 && Auth::user()->role  > 1){
                    return redirect()->route('book.index');    
                }else{
                    return redirect()->route('orders.index');    
                }
            }else{
                Session::flash('error', trans('text.account_locked'));
                return redirect()->route('backend.login-form'); 
            }
        }else {
            // if any error send back with message.
            Session::flash('error', trans('text.wrong'));
            return redirect()->route('backend.login-form');
        }

        return redirect()->route('parent-cate.index');
    }
  
    public function logout()
    {
        Auth::logout();
        return redirect()->route('backend.login-form');
    }   
}
