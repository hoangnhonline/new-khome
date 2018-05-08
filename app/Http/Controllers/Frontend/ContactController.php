<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Articles;
use App\Models\BaoGia;
use App\Models\Settings;

use Helper, File, Session, Auth, Mail;

class ContactController extends Controller
{ 
   
    public function store(Request $request)
    {
        $dataArr = $request->all();
        $type = isset($request->type) ? $request->type : 0;
       // var_dump($type)
        if($type == 3){
            $this->validate($request,[                       
                'title' => 'required',
                'fullname' => 'required',
                'content' => 'required',
                'phone' => 'required'         
            ],
            [            
                'fullname.required' => 'Bạn chưa nhập họ và tên.',
                'title.required' => 'Bạn chưa nhập tiêu đề.',            
                'phone.required' => 'Bạn chưa nhập số điện thoại.',
                'content.required' => 'Bạn chưa nhập nội dung.'            
            ]); 
        }else{
            $this->validate($request,[                       
                'email' => 'email|required',
                'fullname' => 'required',
                'content' => 'required',
                'phone' => 'required'         
            ],
            [            
                'fullname.required' => 'Bạn chưa nhập họ và tên.',
                'email.required' => 'Bạn chưa nhập email.',
                'email.email' => 'Địa chỉ email không hợp lệ.',
                'phone.required' => 'Bạn chưa nhập số điện thoại.',
                'content.required' => 'Bạn chưa nhập nội dung.'            
            ]);
        }
               
         $settingArr = Helper::setting();
        $rs = Contact::create($dataArr);
        $emailArr = explode(',', $settingArr['admin_email']);
        
        if($type == 3){
            Mail::send('frontend.contact.email',
                [                   
                    'dataArr'             => $rs
                ],
                function($message) use ($dataArr, $settingArr, $emailArr) {                    
                    $message->subject('Khách hàng gửi khiếu nại');
                    $message->to($emailArr);
                    $message->from('web.0917492306@gmail.com', 'Admin Website Kkaffee');
                    $message->sender('web.0917492306@gmail.com', 'Admin Website Kkaffee');
            });
        }else{
            Mail::send('frontend.contact.email',
                [                   
                    'dataArr'             => $rs
                ],
                function($message) use ($dataArr, $settingArr, $emailArr) {                    
                    $message->subject('Khách hàng gửi liên hệ');
                    $message->to($emailArr);
                    $message->from('web.0917492306@gmail.com', 'Admin Website Kkaffee');
                    $message->sender('web.0917492306@gmail.com', 'Admin Website Kkaffee');
            });
        }       
        
        if($type == 3){
            Session::flash('message', 'Gửi khiếu nại thành công.');
            return redirect()->route('pages', 'giai-quyet-khieu-nai');
        }else{
            Session::flash('message', 'Gửi liên hệ thành công.');
            return redirect()->route('contact');
        }
        
    }
    public function storeThiCong(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[ 
            'fullname' => 'required',
            'address' => 'required',            
            'phone' => 'required',         
            'email' => 'email|required',
            'kien_truc_thi_cong' => 'required',
            'loai_kien_truc_thi_cong' => 'required',
            'loai_kien_truc_thi_cong' => 'required',
            'hinh_thuc_thi_cong' => 'required',
            'tong_dien_tich' => 'required',
            'so_tang' => 'required',
            'chieu_dai' => 'required',
            'chieu_rong' => 'required',
        ]);       
        $settingArr = Helper::setting();
        $detail = Articles::find($dataArr['id'] );
        $dataArr['type'] = 2;
        $rs = BaoGia::create($dataArr);
        if($rs->id){
            Mail::send('frontend.services.email',
                [                   
                    'dataArr'             => $rs
                ],
                function($message) use ($dataArr, $settingArr) {                    
                    $message->subject('Khách hàng yêu cầu báo giá: Thi công xây dựng');
                    $message->to([$settingArr['admin_email']]);
                    $message->from('web.0917492306@gmail.com', 'Admin Website Houseland');
                    $message->sender('web.0917492306@gmail.com', 'Admin Website Houseland');
            });
        }
        Session::flash('message', 'Gửi yêu cầu báo giá thành công.');

        return redirect()->route('services-detail', [ $detail->slug, $detail->id ]);
    }
    public function storeThietKe(Request $request)
    {
        $dataArr = $request->all();
        
        $this->validate($request,[ 
            'fullname' => 'required',                   
            'phone' => 'required',         
            'email' => 'email|required',
            'kien_truc_thiet_ke' => 'required',
            'hinh_thuc_kien_truc' => 'required',
            'so_tang_thiet_ke' => 'required',
            'mat_tien' => 'required',           
            'chieu_dai' => 'required',
            'chieu_rong' => 'required',
        ]);      
        $settingArr = Helper::setting(); 
        $detail = Articles::find($dataArr['id'] );
        $dataArr['type'] = 1;
        $rs = BaoGia::create($dataArr);
        if($rs->id){
            Mail::send('frontend.services.email',
                [                   
                    'dataArr'             => $rs
                ],
                function($message) use ($dataArr, $settingArr) {                    
                    $message->subject('Khách hàng yêu cầu báo giá: thiết kế kiến trúc');
                    $message->to([$settingArr['admin_email']]);
                    $message->from('web.0917492306@gmail.com', 'Admin Website Houseland');
                    $message->sender('web.0917492306@gmail.com', 'Admin Website Houseland');
            });
        }
        Session::flash('message', 'Gửi yêu cầu báo giá thành công.');

        return redirect()->route('services-detail', [ $detail->slug, $detail->id ]);
    }
    
}
