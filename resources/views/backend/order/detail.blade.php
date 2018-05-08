@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Chi tiết đơn đặt hàng #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route( 'orders.index' ) }}">Đơn đặt hàng</a></li>
    <li class="active">Chi tiết đơn hàng</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
 <a class="btn btn-default btn-sm" href="{{ route('orders.index') }}?status={{ $s['status'] }}&name={{ $s['name'] }}&date_from={{ $s['date_from'] }}&date_to={{ $s['date_to'] }}" style="margin-bottom:5px">Quay lại</a>

  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif
      <div class="box">      
        @if ($success == 1)
            <div class="alert alert-info" style="text-align: left;">
                <ul>
                    
                  <li>Cập nhật thành công.</li>
                    
                </ul>
            </div>
        @endif    
        <div class="box-header with-border">
        @if(Auth::user()->role == 3)
        <form method="POST" action="{{ route('orders.update-detail')}}">
        {{ csrf_field() }}
        @endif
          <div class="col-md-4">
              <h4>Chi tiết chung</h4>
            <p>
              <span>Thời gian đặt hàng :</span><br> {{ date('d-m-Y H:i', strtotime($order->created_at )) }} <br>
              <span>Ngày nhận hàng :</span><br> <strong>{{ $order->date_delivery ? date('d/m/Y', strtotime($order->date_delivery)) : "" }} {{ $order->time_delivery }} </strong><br>
              <div class="clearfix" style="margin-bottom:5px"></div>
              <span>Tình trạng đơn hàng : </span><br />
              <select class="select-change-status form-control" order-id="{{ $order->id }}" style="width:200px;" >
                  @foreach($list_status as $index => $status)
                  <option value="{{$index}}"
                    @if($index == $order->status)
                      selected
                    @endif
                    >{{$status}}</option>
                  @endforeach
                </select>                  
             <div class="clearfix" style="margin:5px"></div>
              <span>Khách hàng : <span><br>
              <span>{{ $order->customer->fullname }}( # {{ $order->customer->email }})</span>
              
            </p>
          </div>
          <div class="col-md-3">
            <h4>Thông tin thanh toán</h4>
            <p>
              <span>Địa chỉ :</span><br> {{ $order->address->address }}, {{ $order->address->ward_id ? Helper::getName($order->address->ward_id, 'ward') : "" }}, {{ $order->address->district_id ? Helper::getName($order->address->district_id, 'district') : "" }}, {{ $order->address->city_id ? Helper::getName($order->address->city_id, 'city') : "" }}<br>
              <div class="clearfix" style="margin-bottom:5px"></div>
              <span>Email : </span><br />
              <span>{{ $order->address->email }}</span>                  
             <div class="clearfix" style="margin:5px"></div>
              <span>Điện thoại : <span><br>
              <span>{{ $order->address->phone }}</span>
              
            </p>
          </div>
          <div class="col-md-5">
            <h4>Chi tiết giao nhận hàng</h4>
            @if(Auth::user()->role == 3)
            <div class="other-address">
                      <div class="row">
                      <input type="hidden" name="id" value="{{ $order->address->id }}">
                      <input type="hidden" name="order_id" value="{{ $order->id }}">
                          <div class="form-group col-md-12">
                            <input type="text" class="form-control no-round req" id="fullname" name="fullname" placeholder="Họ tên" value="{{ $order->address->fullname }}">
                          </div>
                          <div class="form-group col-md-12">
                            <input type="text" class="form-control no-round req" id="phone" name="phone" placeholder="Số điện thoại" value="{{ $order->address->phone }}">
                          </div>
                          <div class="form-group col-md-12">
                            <input type="email" class="form-control no-round" id="email" name="email" placeholder="Email" value="{{ $order->address->email }}">
                          </div>
                      </div>
                      
                      <div class="div-parent" id="primary_address">
                        <div class="row">
                            <div class="col-md-12">
                                <select class="form-group form-control city_id req" name="city_id" id="city_id">
                                    <option>Tỉnh/TP</option>
                                    @foreach($cityList as $city)
                                      <option value="{{$city->id}}"
                                      @if($order->address->city_id == $city->id)
                                      selected
                                      @endif
                                      >{{$city->name}}</option>
                                    @endforeach                                
                                                                    </select>
                            </div>
                            <div class="col-md-12">
                                <select class="form-group form-control no-round district_id req" name="district_id" id="district_id">
                                    <option>Quận/Huyện</option>                              
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <select class="form-control no-round ward_id req" name="ward_id" id="ward_id">
                                    <option>Phường/Xã</option>
                                </select>
                            </div>
                        </div>                    
                      </div>
                      <div class="form-group row">
                          <div class="col-md-12"><input type="text" class="form-control no-round req" id="address" name="address" placeholder="Địa chỉ" value="{{ $order->address->address }}"></div>
                      </div>
                      <div class="form-group row" style="margin-top: 15px;">
                          <div class="col-md-12">
                            <label style="color:red">Ghi chú đơn hàng</label>
                            <textarea name="notes" id="notes" class="form-control" placeholder="">{{ $order->notes }}</textarea>
                          </div>
                      </div>
                  </div>  
                  @else
                        <strong>{{ $order->address->fullname }} - {{ $order->address->phone }}</strong>
       -            <p>
       -              <span>Địa chỉ :</span><br> {{ $order->address->address }}, {{ $order->address->ward_id ? Helper::getName($order->address->ward_id, 'ward') : "" }}, {{ $order->address->district_id ? Helper::getName($order->address->district_id, 'district') : "" }}, {{ $order->address->city_id ? Helper::getName($order->address->city_id, 'city') : "" }}<br>         
       -              
       -            </p>
                @if($order->notes)
                <p style="color:red; padding-top: 15px; margin-top: 15px; clear: both"><u>Ghi chú: </u><span >{{ $order->notes }}</span></p>
                @endif
                  @endif

          </div>
           @if($order->notes)
                <p style="color:red; padding-top: 15px; margin-top: 15px; clear: both"><u>Ghi chú: </u><span >{{ $order->notes }}</span></p>
                @endif
          @if(Auth::user()->role == 3)
            <div class="box-footer" style="text-align:right">             
              <button type="submit" class="btn btn-primary btn-sm" id="btnSave">Lưu</button>
              <a href="{{ route('orders.index') }}" class="btn btn-default btn-sm" class="btn btn-primary btn-sm">Hủy</a>
            </div>

            </form>
            @endif
        </div>

        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width:1%">No.</th>
              <th> Tên Sản phẩm </th>
              <th style="text-align:right"> Số Lượng </th>
              <th style="text-align:center">Giá bán </th>
              <th style="text-align:center">Tổng</th>              
            </tr>
            <tbody>
            <?php $i = 0; ?>
            @foreach($order_detail as $detail)
            <?php $i++; ?>
              <tr>
                  <td style="text-align:center">{{ $i }}</td>
                  <td class="product_name">{{$detail->product->name}}</td>
                  <td style="text-align:right">{{$detail->so_luong}}</td>
                  <td style="text-align:right">{{number_format($detail->don_gia)}} đ</td>
                  <td style="text-align:right">{{number_format($detail->tong_tien)}} đ</td>
                 
              </tr>
            @endforeach
              <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align:right"><b>Phí vận chuyển</b></td>
                  <td style="text-align:right">{{number_format($order->phi_van_chuyen)}} đ</td>
              </tr>
              <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align:right"><b>Tổng chi phí</b></td>
                  <td style="text-align:right">
                    <strong>{{number_format($order->tong_tien)}}</strong> đ</td>
              </tr>
          </tbody>
          </table>
        </div>
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
</section>
<!-- /.content -->
</div>
@stop
@section('js')
<script type="text/javascript">

$(document).ready(function(){
  $('.city_id').change(function(){         
        var obj = $(this);
            $.ajax({
              url : '{{ route('get-child') }}',
              data : {
                mod : 'district',
                col : 'city_id',
                id : obj.val()
              },
              type : 'POST',
              dataType : 'html',
              success : function(data){
                obj.parents('.div-parent').find('.district_id').html(data);      
              }
            });
          
        });
  @if($order->address->city_id)
  $.ajax({
              url : '{{ route('get-child') }}',
              data : {
                mod : 'district',
                col : 'city_id',
                id : {{ $order->address->city_id }}
              },
              type : 'POST',
              dataType : 'html',
              success : function(data){
                $('#district_id').html(data).val({{ $order->address->district_id }});      

              }
            });
  @endif
   @if($order->address->district_id)
  $.ajax({
              url : '{{ route('get-child') }}',
              data : {
                mod : 'ward',
                col : 'district_id',
                id : {{ $order->address->district_id }}
              },
              type : 'POST',
              dataType : 'html',
              success : function(data){
                $('#ward_id').html(data).val({{ $order->address->ward_id }});      

              }
            });
  @endif
  $('#district_id').change(function(){         
        var obj = $(this);
            $.ajax({
              url : '{{ route('get-child') }}',
              data : {
                mod : 'ward',
                col : 'district_id',
                id : obj.val()
              },
              type : 'POST',
              dataType : 'html',
              success : function(data){
                $('#ward_id').html(data);                                
              }
            });
          
        });
  $('.btn-delete-order-detail').click(function(){
    var order_detail_id = $(this).attr('order-detail-id');
    var order_id = $(this).attr('order-id');
    if(confirm('Bạn có muốn xoá sản phẩm ' + $(this).parents('tr').find('.product_name').text() +' này trong đơn hàng ?')) {
      delete_order_detail(order_id, order_detail_id);
    }
  });
   $('.select-change-status').change(function(){
      var status_id = $(this).val();
      var order_id  = $(this).attr('order-id');
      var customer_id = $(this).attr('customer-id');
      update_status_orders(status_id, order_id, customer_id);
    });

    function update_status_orders(status_id, order_id, customer_id) {
      $.ajax({
        url: '{{route('orders.update')}}',
        type: "POST",
        data: {
          status_id : status_id,
          order_id : order_id,
          customer_id : customer_id
        },
        success: function (response) {
          location.reload()
        },
        error: function(response){

        }
      });
    }
  function delete_order_detail(order_id, order_detail_id) {
    $.ajax({
      url: '{{route('order.detail.delete')}}',
      type: "POST",
      data: {
        order_id        : order_id,
        order_detail_id : order_detail_id
      },
      success: function (response) {
        location.reload()
      },
      error: function(response){

      }
    });
  }

});

</script>
@stop