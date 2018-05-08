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
      <tr>
        <td width="200px" class="tieu-de">Ghi chú</td>
        <td class="gia-tri">{{ $dataArr->content }}</td>
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