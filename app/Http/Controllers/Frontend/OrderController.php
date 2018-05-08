<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\LoaiSp;
use App\Models\Cate;
use App\Models\Product;
use App\Models\ProductImg;
use App\Models\Banner;
use App\Models\Orders;
use App\Models\OrderDetail;
use App\Models\Settings;
use App\Models\CustomerAddress;

use App\Models\Customer;
use Helper, File, Session, Auth;
use Mail;
use Carbon\Carbon;

class OrderController extends Controller
{

  protected $status = [
     0 => 'Chờ xử lý',       
      2 => 'Đang vận chuyển',
      3 => 'Đã hoàn thành',
      4 => 'Đã huỷ'    
  ];

  public function detail(Request $request)
  {
    $lang = Session::get('locale') ? Session::get('locale') : 'vi';
    $order_id = $request->order_id;
    $order = Orders::find($order_id);
    $customer_id = Session::get('userId'); 

    if($order->customer_id != $customer_id){
      return redirect()->route('home');
    }else{
      $orderDetail = $order->order_detail;      
    }
    foreach($orderDetail as $detail){
      $detailArr[$detail->sp_id] = Product::find($detail->sp_id);
    }
    $str_order_id = str_pad($order->id, 6, "0", STR_PAD_LEFT);
     $seo['title'] = $seo['description'] = $seo['keywords'] = "Chi tiết đơn hàng #".$str_order_id;

     $status = $this->status;
     $ngay_dat_hang = Carbon::parse($order->created_at)->format('d-m-Y H:i:s');
     $customer = Customer::find($customer_id);
    return view('frontend.account.order-detail', compact('order', 'orderDetail', 'seo', 'str_order_id', 'status', 'ngay_dat_hang', 'customer', 'detailArr', 'lang'));
  }
  public function huy(Request $request){    
    $order_id = $request->id;
    $order = Orders::find($order_id);
    $customer_id = Session::get('userId');
    if( $customer_id == $order->customer_id && $order->status == 0){
      $order->status = 4;
      $order->save();

      $addressInfo = CustomerAddress::find($order->address_id);

      $email = $addressInfo->email ? $addressInfo->email :  "";
      $settingArr = Settings::whereRaw('1')->lists('value', 'name');
      $adminMailArr = explode(',', $settingArr['email_header']);
      if($email != ''){

          $emailArr = array_merge([$email], $adminMailArr);
      }else{
          $emailArr = $adminMailArr;
      }
      // send email
      $order_id =str_pad($order->id, 6, "0", STR_PAD_LEFT);
      
      if(!empty($emailArr)){
          Mail::send('frontend.cart.cancel-email',
              [
                  'fullname'          => $addressInfo->fullname,
                  'order_id' => $order_id                    
              ],
              function($message) use ($emailArr, $order_id) {
                  $message->subject('Hủy đơn hàng #'.$order_id);
                  $message->to($emailArr);
                  $message->from('kkaffee.vn@gmail.com', 'KKAFFEE');
                  $message->sender('kkaffee.vn@gmail.com', 'KKAFFEE');
          });
      }

    }
  }
  public function show(Request $request)
  {
    $customer_id = Session::get('userId');
    $orders = Orders::where('customer_id', $customer);
    return view('', compact('orders'));
  }

  public function history(Request $request)
  {
    if(!Session::has('userId')) {
      return redirect()->route('home');
    }
    $lang = Session::get('locale') ? Session::get('locale') : 'vi';
    $customer_id = Session::get('userId');
    $customer = Customer::find($customer_id);
    $orders = Orders::where('customer_id', $customer_id)->orderBy('id', 'DESC')->get();
    $status = $this->status;
    
      $seo['title'] = $seo['description'] = $seo['keywords'] = "Đơn hàng của tôi";
    
    return view('frontend.account.order-history', compact('orders', 'status', 'customer', 'seo', 'lang'));
  }

}
