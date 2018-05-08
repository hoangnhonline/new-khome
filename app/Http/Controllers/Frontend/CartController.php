<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cate;
use App\Models\Product;
use App\Models\City;
use App\Models\Banner;
use App\Models\Orders;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\CustomerAddress;
use App\Models\Settings;
use Helper, File, Session, Auth;
use Mail;

class CartController extends Controller
{

    public static $loaiSp = [];
    public static $loaiSpArrKey = [];


    /**
    * Session products define array [ id => quantity ]
    *
    */

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
    public function index(Request $request)
    {
        if(!Session::has('products')) {
            return redirect()->route('home');
        }

        $getlistProduct = Session::get('products');
        
        $listProductId = array_keys($getlistProduct);
    
        $arrProductInfo = Product::whereIn('product.id', $listProductId)->get();        
        
        $seo['title'] = $seo['description'] = $seo['keywords'] = "Giỏ hàng";
        return view('frontend.cart.index', compact('arrProductInfo', 'getlistProduct', 'seo'));
    }

    public function addressInfo(Request $request){        
        if(!Session::has('products')) {
            return redirect()->route('home');
        }
        //dd(Session::get('address_info'));
        $getlistProduct = Session::get('products');
        
        $listProductId = array_keys($getlistProduct);
    
        $arrProductInfo = Product::whereIn('product.id', $listProductId)->get();
        
        
        $seo['title'] = $seo['description'] = $seo['keywords'] = "Thời gian & địa chỉ nhận hàng";
        

        $cityList = City::orderBy('display_order')->get();

        $userId = Session::get('userId');
        $customer = Customer::find($userId);
        
        $addressList = $customer->customerAddress;
        $branchArr = Branch::whereRaw('1=1')->groupBy('district_id')->pluck('district_id')->toArray();        
        return view('frontend.cart.address-info', compact('arrProductInfo', 'getlistProduct', 'seo', 'cityList', 'customer', 'addressList', 'branchArr'));
    }

    public function storeAddress(Request $request){
        $dataArr = $request->all();
        
        Session::put('address_info', $dataArr);
        if(!isset($dataArr['address_id'])){
            $rs = CustomerAddress::create(
                [
                    'customer_id' => Session::get('userId'),
                    'city_id' => $dataArr['city_id'],
                    'district_id' => $dataArr['district_id'],
                    'ward_id' => $dataArr['ward_id'],
                    'email' => $dataArr['email'],
                    'phone' => $dataArr['phone'],
                    'address' => $dataArr['address'],
                    'fullname' => $dataArr['fullname'],
                    'is_primary' => 1                
                ]
            );
            $address_id = $rs->id;
        }
        if(isset($dataArr['choose_other'])){
            $rs = CustomerAddress::create(
                [
                    'customer_id' => Session::get('userId'),
                    'city_id' => $dataArr['other_city_id'],
                    'district_id' => $dataArr['other_district_id'],
                    'ward_id' => $dataArr['other_ward_id'],
                    'email' => $dataArr['other_email'],
                    'phone' => $dataArr['other_phone'],
                    'fullname' => $dataArr['other_fullname'],
                    'address' => $dataArr['other_address'],
                    'is_primary' => 0                
                ]
            );
            $address_id = $rs->id;
        }else{
            $address_id = isset($dataArr['address_id']) ? $dataArr['address_id'] : $address_id;
        }
        //
        $branch_id = $dataArr['k_branch_id'];
        Session::put('branch_id', $branch_id);
        $branchDetail = Branch::find($branch_id);
        
        $branchAddress = $branchDetail->address.", ".$branchDetail->ward->name.", ".$branchDetail->district->name.", ".$branchDetail->city->name.", Việt Nam";
        $addressDetail = CustomerAddress::find($address_id);
        $addressNhan = $addressDetail->address.", ".$addressDetail->ward->name.", ".$addressDetail->district->name.", ".$addressDetail->city->name.", Việt Nam";

        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins='.urlencode($branchAddress).'&destinations='.urlencode($addressNhan).'&key=AIzaSyAhxs7FQ3DcyDm8Mt7nCGD05BjUskp_k7w';
        // create curl resource
        $ch = curl_init();
        // set url
        curl_setopt($ch, CURLOPT_URL, $url);
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string
        $output = curl_exec($ch);
        // close curl resource to free up system resources
        curl_close($ch);
        $data = json_decode($output, true);

        $status = $data['rows'][0]['elements'][0]['status'];
        if($status == 'NOT_FOUND'){
            $text_dis = "Không tìm thấy địa chỉ";
            $km_dis = 0;
        }else{
            $text_dis = $data['rows'][0]['elements'][0]['distance']['text'];
            $tmp = explode(" ", $text_dis);
            $km_dis = $tmp['0'];    
        }        

        Session::put('phi_van_chuyen', ['km' => $km_dis, 'text' => $text_dis, 'phi' => 5000*$km_dis]);       

        Session::put('address_id', $address_id);
        Session::put('notes', $dataArr['notes']);

        return redirect()->route('payment-method');
    }
    public function paymentInfo(Request $request){     
        
        $addressInfo = Session::get('address_info');
     
        $detailPrimary = CustomerAddress::find(Session::get('address_id'));
        //dd($detailPrimary);
        $getlistProduct = Session::get('products');
        
        $listProductId = array_keys($getlistProduct);
    
        $arrProductInfo = Product::whereIn('product.id', $listProductId)->get();        
        
        $seo['title'] = $seo['description'] = $seo['keywords'] = "Phương thức thanh toán";

        return view('frontend.cart.payment-method', compact('getlistProduct', 'listProductId','arrProductInfo', 'seo', 'detailPrimary'));
    }
    public function getBranch(Request $request){
        $district_id = $request->district_id;        

        $branchList = Branch::where('district_id', $district_id)->orderBy('display_order')->get();

        return view('frontend.cart.branch', compact('branchList'));
    }
    public function update(Request $request)
    {
        $listProduct = Session::get('products');
        if($request->quantity) {
            $listProduct[$request->id] = $request->quantity;
        } else {
            unset($listProduct[$request->id]);
        }
        Session::put('products', $listProduct);
        return 'sucess';
    }

    public function addProduct(Request $request)
    {
        $listProduct = Session::get('products');
        if(!empty($listProduct[$request->id])) {
            $listProduct[$request->id] += 1;
        } else {
            $listProduct[$request->id] = 1;
        }

        Session::put('products', $listProduct);

        return 'sucess';
    }

    public function updateUserInformation(Request $request)
    {
        $getlistProduct = Session::get('products');

        $listProductId = $getlistProduct ? array_keys($getlistProduct) : [];

        $listCity = City::orderBy('display_order')->get();

        $userId = Session::get('userId');
        $customer = Customer::find($userId);

        if(is_null($customer)) $customer = new Customer;
        $seo = Helper::seo();
        return view('frontend.cart.register-infor', compact('customer', 'listCity', 'seo'));
    }

    public function saveOrder(Request $request)
    {
        $addInfo = Session::get('address_info');
        $getlistProduct = Session::get('products');
        $listProductId = array_keys($getlistProduct);
        $customer_id = Session::get('userId');
        $customer = Customer::find($customer_id);
        
        $arrProductInfo = Product::whereIn('product.id', $listProductId)
                            ->get();
        $order['tong_tien'] = 0;
        $order['tong_sp'] = array_sum($getlistProduct);
        $order['giam_gia'] = 0;
        $order['tien_thanh_toan'] = 0;
        $order['customer_id'] = Session::get('userId');
        $order['status'] = 0;
        $order['coupon_id'] = 0;
        $order['method_id'] = $request->method_id;
        
        $date_delivery = $addInfo['date_delivery'] ? str_replace('/', '-', $addInfo['date_delivery'] ) : null;
        if($date_delivery){
            $date_delivery = date('Y-m-d', strtotime($date_delivery));
        }else{
            $date_delivery = null;
        }
        $order['date_delivery'] = $date_delivery;
        $order['time_delivery'] = $addInfo['time_delivery'];
        $order['address_id'] = Session::get('address_id');
        $order['branch_id'] = Session::get('branch_id');
        $order['notes'] = Session::get('notes');

        // check if ho chi minh free else 150k
        $order['phi_van_chuyen'] = Session::get('phi_van_chuyen')['phi'];
        $order['phi_cod'] = 0;
        
        $order['service_fee'] = 0;
        foreach ($arrProductInfo as $product) {
            $price = $product->is_sale ? $product->price_sale : $product->price;        
            $order['tong_tien'] += $price * $getlistProduct[$product->id];
        }
        $order['phi_phuc_vu'] = $order['tong_tien']*10/100;
        $order['tong_tien'] = $order['tien_thanh_toan'] = $order['tong_tien'] + $order['phi_van_chuyen'] + $order['service_fee'] + $order['phi_cod'] + $order['phi_phuc_vu'];
        
        $getOrder = Orders::create($order);

        $order_id = $getOrder->id;

        Session::put('order_id', $order_id);

        $orderDetail['order_id'] = $order_id;
       
        foreach ($arrProductInfo as $product) {            
            # code...
            $orderDetail['sp_id']        = $product->id;
            $orderDetail['so_luong']     = $getlistProduct[$product->id];
            $orderDetail['don_gia']      = $product->price;
            $orderDetail['tong_tien']    = $getlistProduct[$product->id]*$product->price;                       
            OrderDetail::create($orderDetail); 
        }

        $customer_id = Session::get('userId');
        $customer = Customer::find($customer_id);
        
        $addressInfo = CustomerAddress::find(Session::get('address_id'));

        $email = $addressInfo->email ? $addressInfo->email :  "";
        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
        $adminMailArr = explode(',', $settingArr['email_header']);
		foreach($adminMailArr as $emailS){
			$adminEmail[] = trim($emailS);
		}
        if($email != ''){

            $emailArr = array_merge( $adminEmail, [$email]);
        }else{
            $emailArr = $adminEmail;
        }
        // send email
        $order_id =str_pad($order_id, 6, "0", STR_PAD_LEFT);
        
        if(!empty($emailArr)){
            Mail::send('frontend.cart.email',
                [
                    'customer'          => $customer,
                    'orderDetail'             => $getOrder,
                    'addressInfo' => $addressInfo,
                    'arrProductInfo'    => $arrProductInfo,
                    'getlistProduct'    => $getlistProduct,
                    'method_id' => $order['method_id'],
                    'order_id' => $order_id                    
                ],
                function($message) use ($emailArr, $order_id) {
                    $message->subject('Xác nhận đơn hàng hàng #'.$order_id);
                    $message->to($emailArr);
                    $message->from('kkaffee.vn@gmail.com', 'K Minimart & Kaffee');
                    $message->sender('kkaffee.vn@gmail.com', 'K Minimart & Kaffee');
            });
        }
        
        return redirect()->route('success');

    }

    public function success(Request $request){
       
        Session::put('products', []);
        Session::put('order_id', '');
        Session::forget('address_id');
        Session::forget('address_info');
        Session::forget('phi_van_chuyen');
        Session::forget('notes');
        Session::forget('branch_id');
        
        $seo = Helper::seo();

        return view('frontend.cart.success', compact('seo'));
    }

    public function deleteAll(){
        Session::put('products', []);
        return redirect()->route('cart');
    }
}

