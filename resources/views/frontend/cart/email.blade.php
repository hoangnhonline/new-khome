<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mail</title>
</head>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#dcf0f8" style="margin:0;padding:0;background-color:#f2f2f2;width:100%!important;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
  <tbody>
    <tr>
      <td align="center" valign="top" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><table border="0" cellpadding="0" cellspacing="0" width="600" style="margin-top:15px">
          <tbody>
            <tr style="background:#fff">
              <td align="left" width="600" height="auto" style="padding:15px"><table>
                  <tbody>
                    <tr>
                      <td>
                      
                      <h1 style="font-size:17px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0"> Cảm ơn
                          quý khách {{ $addressInfo->fullname }}
                          đã đặt hàng tại <strong>K Minimart & Kaffee</strong>,</h1>                    
                        <p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"> <strong>K Minimart & Kaffee</strong> rất vui thông báo đơn hàng #{{ $order_id }} của quý khách đã
                          được tiếp nhận và đang trong <strong>“Quá trình xử lý”</strong>. <strong>K Minimart & Kaffee</strong> sẽ thông báo đến quý khách ngay khi hàng chuẩn bị được giao. </p>
                        </td>
                    </tr>
                    <tr>
                      <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px"><table cellspacing="0" cellpadding="0" border="0" width="100%">
                          <thead>
                            <tr>
                              <th align="left" width="50%" style="padding:6px 9px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold"> Thông tin thanh toán </th>
                              <th align="left" width="50%" style="padding:6px 9px 0px 9px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;font-weight:bold"> Địa chỉ giao hàng </th>
                            </tr>
                          </thead>
                          <tbody>
                            
                           <tr>
                              <td valign="top" style="padding:3px 9px 9px 9px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><span style="text-transform:capitalize">{{ $orderDetail->address->fullname }}</span><br>
                                
                                {!! $orderDetail->address->phone !!} </td>
                              <td valign="top" style="padding:3px 9px 9px 9px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><span style="text-transform:capitalize">{!! $orderDetail->address->fullname !!}</span><br>
                                <a href="mailto:{!! $addressInfo->email !!}" target="_blank">{!! $orderDetail->address->email !!}</a><br>                                
                                  {!! $orderDetail->address->city->name !!},                                
                                  {!! $orderDetail->address->district->name !!},                                
                                {!! $orderDetail->address->address !!} <br>
                                {!! $orderDetail->address->phone !!}<br>
                            </tr>
                            
                            <tr>
                             <td valign="top" style="padding:7px 9px 0px 9px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444" colspan="2"><p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"> <strong>Phương thức thanh toán: </strong> 
                            <?php 
                            if($method_id == 1) {
                              echo "COD";
                            }elseif( $method_id == 2){
                              echo "Thanh toán bằng thẻ của K KAFFEE";
                            }
                              ?>
                              </td>
                            </tr>
                            <tr>
                             <td valign="top" style="padding:7px 9px 0px 9px;border-top:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444" colspan="2"><p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"> <strong>Ngày nhận hàng: </strong> 
                              {{
                                $orderDetail->date_delivery ? date('d-m-Y', strtotime($orderDetail->date_delivery)) : ""
                              }}
                              {{
                                $orderDetail->time_delivery
                              }}
                              </td>
                            </tr>
                            @if($orderDetail->notes)
                            <tr>
                              <td colspan="2" style="color:red">Ghi chú : {{ $orderDetail->notes }}</td>
                            </tr>
                            @endif
                          </tbody>
                        </table></td>
                    </tr>
                    
                    <tr>
                      <td><h2 style="text-align:left;margin:10px 0;border-bottom:1px solid #ddd;padding-bottom:5px;font-size:13px;color:#ffde00"> CHI TIẾT ĐƠN HÀNG</h2>
                        <table cellspacing="0" cellpadding="0" border="0" width="100%" style="background:#f5f5f5">
                          <thead>
                            <tr>
                              <th align="left" bgcolor="#ffde00" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Sản phẩm</th>
                              <th align="left" bgcolor="#ffde00" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px"> Đơn giá</th>
                              <th align="left" bgcolor="#ffde00" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Số lượng</th>
                              <th align="left" bgcolor="#ffde00" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Giảm giá</th>
                              <th align="right" bgcolor="#ffde00" style="padding:6px 9px;color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:14px">Tổng tạm</th>
                            </tr>
                          </thead>
                          <tbody bgcolor="#eee" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                              <?php $total = 0 ?>
                              @foreach($arrProductInfo as $product)
                                <?php
                                  $price = $product->is_sale ? $product->price_sale : $product->price;
                                ?>
                              <tr>
                              <td align="left" valign="top" style="padding:3px 9px"><span>{!! $product->name !!}</span><br>
                              <td align="left" valign="top" style="padding:3px 9px"><span>{!! number_format($price) !!}&nbsp;₫</span></td>
                              <td align="left" valign="top" style="padding:3px 9px">{!! $getlistProduct[$product->id] !!}</td>
                              <td align="left" valign="top" style="padding:3px 9px"><span>0&nbsp;₫</span></td>
                              <td align="right" valign="top" style="padding:3px 9px"><span>{!! number_format($price * $getlistProduct[$product->id]) !!}&nbsp;₫</span></td>
                              <?php $total += $price * $getlistProduct[$product->id] ?>
                               </tr>
                              @endforeach
                          </tbody>
                          <tfoot style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                            <tr>
                              <td colspan="4" align="right" style="padding:5px 9px">Tổng giá trị sản phẩm chưa giảm</td>
                              <td align="right" style="padding:5px 9px"><span>{!! number_format($total) !!}&nbsp;₫</span></td>
                            </tr>
                            <tr>
                              <td colspan="4" align="right" style="padding:5px 9px">Phí phục vụ (10%)</td>
                              <td align="right" style="padding:5px 9px"><span>{{ number_format($orderDetail->phi_phuc_vu) }}&nbsp;₫</span></td>
                            </tr>
                            <tr>
                              <td colspan="4" align="right" style="padding:5px 9px">Giảm giá </td>
                              <td align="right" style="padding:5px 9px"><span>0&nbsp;₫</span></td>
                            </tr>
                            <tr>
                              <td colspan="4" align="right" style="padding:5px 9px">Chi phí vận chuyển</td>
                              <td align="right" style="padding:5px 9px"><span>{{ number_format($orderDetail->phi_van_chuyen) }}&nbsp;₫</span></td>
                            </tr>                            
                            <tr bgcolor="#eee">
                              <td colspan="4" align="right" style="padding:7px 9px"><strong><big>Tổng giá trị đơn hàng</big></strong></td>
                              <td align="right" style="padding:7px 9px"><strong><big><span>{!! number_format($orderDetail->tong_tien) !!}&nbsp;₫</span></big></strong></td>
                            </tr>
                          </tfoot>
                        </table>                        
                    </tr>                    
                  </tbody>
                </table></td>
            </tr>
          </tbody>
        </table></td>
    </tr>    
  </tbody>
</table>

</body>
</html>