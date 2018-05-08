@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Chi nhánh    
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('branch.index') }}">Chi nhánh</a></li>
      <li class="active">Tạo mới</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('branch.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('branch.store') }}">
    <div class="row">
      <!-- left column -->

      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Tạo mới</h3>
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}

            <div class="box-body">
              @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif             
                
                <div class="form-group" >
                  
                  <label>Tên Chi nhánh <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                </div>
                <div class="row"  style="margin-top: 15px;">
               <div class="form-group col-md-4">
                    <select class="form-group form-control no-round city_id" name="city_id" id="city_id">
                        <option>Tỉnh/TP</option>
                        @foreach($cityList as $city)
                          <option value="{{$city->id}}"
                          @if(old('branch_city_id') == $city->id)
                          selected
                          @endif
                          >{{$city->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class=" form-group col-md-4">
                    <select class="form-group form-control no-round district_id" name="district_id" id="district_id">
                        <option>Quận/Huyện</option>                              
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <select class="form-control no-round ward_id" name="ward_id" id="ward_id">
                        <option>Phường/Xã</option>
                    </select>
                </div>   
                </div>          
                <div class="clearfix"></div>
                 <div class="form-group" >
                  
                  <label>Địa chỉ <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="address" id="address" value="{{ old('address') }}">
                </div>               
                 <div class="form-group" >
                  
                  <label>Số điện thoại</label>
                  <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}">
                </div>               
                  
            </div>          
                              
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('branch.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>      
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@stop
@section('js')
<script type="text/javascript">
  $(document).ready(function(){
    $('#city_id').change(function(){         
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
                $('#district_id').html(data);      
              }
            });
          
        });
     
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
  });
</script>
@stop
