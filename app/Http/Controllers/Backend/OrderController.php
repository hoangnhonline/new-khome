<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Orders;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Settings;
use App\Models\CustomerAddress;
use App\Models\City;

use DB;
use Mail, Session, URL;
class OrderController extends Controller
{
    protected $list_status = [
        0 => 'Chờ xử lý',       
        2 => 'Đang vận chuyển',
        3 => 'Đã hoàn thành',
        4 => 'Đã huỷ'    
      ];
    public function __construct(){
        // Session::put('products', [
        //     '1' => 2,
        //     '3' => 3
        // ]);
        // Session::put('login', true);
        // Session::put('userId', 1);
        // Session::forget('login');
        // Session::forget('userId');
        date_default_timezone_set("Asia/Ho_Chi_Minh");

    }
    public function index(Request $request){     
        $s['status'] = $status = isset($request->status) ? $request->status : -1;
        $s['date_from'] = $date_from = isset($request->date_from) && $request->date_from !='' ? $request->date_from : date('d-m-Y');
        $s['date_to'] = $date_to = isset($request->date_to) && $request->date_to !='' ? $request->date_to : date('d-m-Y');
        $s['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';       

        $query = Orders::whereRaw('1');
        if( $status > -1){
            $query->where('orders.status', $status);
        }
        if( $date_from ){
            $dateFromFormat = date('Y-m-d', strtotime($date_from));
            $query->whereRaw("DATE(orders.created_at) >= '".$dateFromFormat."'");
        }
        if( $date_to ){
            $dateToFormat = date('Y-m-d', strtotime($date_to));
            $query->whereRaw("DATE(orders.created_at) <= '".$dateToFormat."'");
        }
        if( $name != '' ){            
            $query->whereRaw(" ( customer_address.email LIKE '%".$name."%' ) OR ( customer_address.fullname LIKE '%".$name."%' )");
        }
        $query->join('customer_address', 'customer_address.id', '=', 'orders.address_id')->select(['orders.*', 'customer_address.*', 'orders.id as order_id', 'orders.created_at as time_mua']);
        $orders = $query->orderBy('orders.id', 'DESC')->paginate(20);
        $list_status = $this->list_status;
       
        return view('backend.order.index', compact('orders', 'list_status','s'));
    }


    public function orderDetail(Request $request, $order_id)
    {
        $order = Orders::find($order_id);
        $order_detail = OrderDetail::where('order_id', $order_id)->get();
        $list_status = $this->list_status;
        $s['status'] = $request->status;
        $s['name'] = $request->name;
        $s['date_from'] = $request->date_from;
        $s['date_to'] = $request->date_to;
        $cityList = City::orderBy('display_order')->get();
        $success = isset($request->success) ? 1 : 0;
        return view('backend.order.detail', compact('order', 'order_detail', 'list_status', 's', 'cityList', 'success'));
    }

    public function orderDetailDelete(Request $request)
    {
        $order_id = $request->order_id;
        $order_detail_id = $request->order_detail_id;

        $order = Orders::find($order_id);
        $order_detail = OrderDetail::find($order_detail_id);

        $order->tien_thanh_toan -= $order_detail->tong_tien;
        $order->tong_tien       -= $order_detail->tong_tien;
        $order->save();

        OrderDetail::destroy($order_detail_id);
        return 'success';
    }

    public function update(Request $request){
        $status_id   = $request->status_id;
        $order_id    = $request->order_id;
        $customer_id = $request->customer_id;

        Orders::where('id', $order_id)->update([
            'status' => $status_id
        ]);
        //get customer to send mail
        $customer = Customer::find($customer_id);
        $order = Orders::find($order_id);
       
        switch ($status_id) {
            case "1":
               
                break;
            case "3":
                $orderDetail = OrderDetail::where('order_id', $order_id)->get();
                foreach($orderDetail as $detail){
                    $product_id = $detail->sp_id;                    
                    $so_luong = $detail->so_luong;
                    $modelProduct = Product::find($product_id);
                    $so_luong_ton =  $modelProduct->inventory - $so_luong;
                    $so_luong_ton  = $so_luong_ton > 0 ? $so_luong_ton : 0;
                    $modelProduct->update(['inventory' => $so_luong_ton]);
                }         
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
                    Mail::send('frontend.cart.done-email',
                        [
                            'fullname'          => $addressInfo->fullname,
                            'order_id' => $order_id                    
                        ],
                        function($message) use ($emailArr, $order_id) {
                            $message->subject('Hoàn tất đơn hàng #'.$order_id);
                            $message->to($emailArr);
                            $message->from('kkaffee.vn@gmail.com', 'KKAFFEE');
                            $message->sender('kkaffee.vn@gmail.com', 'KKAFFEE');
                    });
                }      
                break;
                case "2":
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
                    Mail::send('frontend.cart.vc-email',
                        [
                            'fullname'          => $addressInfo->fullname,
                            'order_id' => $order_id                    
                        ],
                        function($message) use ($emailArr, $order_id) {
                            $message->subject('Đang vận chuyển đơn hàng #'.$order_id);
                            $message->to($emailArr);
                            $message->from('kkaffee.vn@gmail.com', 'KKAFFEE');
                            $message->sender('kkaffee.vn@gmail.com', 'KKAFFEE');
                    });
                }
                break;         
            case "4":
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
                break;
            default:

                break;
        }
      
        return 'success';
    }
    public function updateDetail(Request $request){
        $data = $request->all();
        $rs = CustomerAddress::find($data['id']);
        $dataA = $data;
        unset($dataA['notes']);
        unset($dataA['order_id']);
        $rs->update($dataA);

        //update notes
        $rs2 = Orders::find($data['order_id']);
        $rs2->update(['notes' => $data['notes']]);
        return redirect(URL::previous()."&success=1");
    }
    public function destroy($id)
    {
        // delete
        $model = Orders::find($id);
        $model->delete();
        OrderDetail::where('order_id', $id)->delete();
        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect(URL::previous());
    }
}
