<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mail</title>
</head>
<body>
<h3>Thông tin khách hàng</h3>
<table align="center" border="1" cellpadding="15" cellspacing="0" width="100%" bgcolor="#dcf0f8" style="margin:0;padding:0;width:100%!important;font-family:Arial,Helvetica,sans-serif;font-size:15px;color:#444;line-height:18px">
  <tbody>
    <tr>
        <td width="200px" class="tieu-de">Loại</td>
        <td class="gia-tri">{{ $dataArr->type == 1 ? "Thiết kế kiến trúc" : "Thi công xây dựng"}}</td>
      </tr>
      <tr>
        <td width="200px" class="tieu-de">Tên khách hàng</td>
        <td class="gia-tri">{{ $dataArr->fullname }}</td>
      </tr>
      <tr>
        <td width="200px" class="tieu-de">Số điện thoại</td>
        <td class="gia-tri">{{ $dataArr->phone }}</td>
      </tr>
      <tr>
        <td width="200px" class="tieu-de">Email</td>
        <td class="gia-tri">{{ $dataArr->email }}</td>
      </tr>
      @if($dataArr->type == 2)
      <tr>
        <td width="200px" class="tieu-de">Địa chỉ</td>
        <td class="gia-tri">{{ $dataArr->address }}</td>
      </tr>
      
      <tr>
        <td width="200px" class="tieu-de">Kiến trúc</td>
        <td class="gia-tri">{{ Helper::getName($dataArr->kien_truc_thi_cong, 'setting_baogia') }}</td>
      </tr>
      <tr>
        <td width="200px" class="tieu-de">Loại kiến trúc thi công</td>
        <td class="gia-tri">{{ Helper::getName($dataArr->loai_kien_truc_thi_cong, 'setting_baogia') }}</td>
      </tr>
      <tr>
        <td width="200px" class="tieu-de">Hình thức thi công xây dựng</td>
        <td class="gia-tri">{{ Helper::getName($dataArr->hinh_thuc_thi_cong, 'setting_baogia') }}</td>
      </tr>
      <tr>
        <td width="200px" class="tieu-de">Tổng diện tích xây dựng</td>
        <td class="gia-tri">{{ $dataArr->tong_dien_tich }}</td>
      </tr>
      <tr>
        <td width="200px" class="tieu-de">Số tầng</td>
        <td class="gia-tri">{{ $dataArr->so_tang }}</td>
      </tr>
      @else
      <tr>
        <td width="200px" class="tieu-de">Kiến trúc</td>
        <td class="gia-tri">{{ Helper::getName($dataArr->kien_truc_thiet_ke, 'setting_baogia') }}</td>
      </tr>
      <tr>
        <td width="200px" class="tieu-de">Hình thức kiến trúc</td>
        <td class="gia-tri">{{ Helper::getName($dataArr->hinh_thuc_kien_truc, 'setting_baogia') }}</td>
      </tr>
      <tr>
        <td width="200px" class="tieu-de">Số tầng thiết kế </td>
        <td class="gia-tri">{{ Helper::getName($dataArr->so_tang_thiet_ke, 'setting_baogia') }}</td>
      </tr>
      <tr>
        <td width="200px" class="tieu-de">Mặt tiền</td>
        <td class="gia-tri">{{ Helper::getName($dataArr->mat_tien, 'setting_baogia') }}</td>
      </tr>               
      @endif
      <tr>
        <td width="200px" class="tieu-de">Chiều dài</td>
        <td class="gia-tri">{{ $dataArr->chieu_dai }}</td>
      </tr>
      <tr>
        <td width="200px" class="tieu-de">Chiều rộng</td>
        <td class="gia-tri">{{ $dataArr->chieu_rong }}</td>
      </tr>
      <tr>
        <td width="200px" class="tieu-de">Ghi chú</td>
        <td class="gia-tri">{{ $dataArr->notes }}</td>
      </tr>
  </tbody>
</table>
<style type="text/css">
  td.tieu-de{
    background-color: #CCC
  }
  td.gia-tri{
    font-size:17px;
    font-weight: bold;
  }
</style>
</body>
</html>