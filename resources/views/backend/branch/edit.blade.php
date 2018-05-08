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
      <li class="active">Cập nhật</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('branch.index') }}" style="margin-bottom:5px">Quay lại</a>
   
    <form role="form" method="POST" action="{{ route('branch.update') }}">
    <div class="row">
      <!-- left column -->
      <input name="id" value="{{ $detail->id }}" type="hidden">
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            Chỉnh sửa
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}

            <div class="box-body">
              @if(Session::has('message'))
              <p class="alert alert-info" >{{ Session::get('message') }}</p>
              @endif
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
                  <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $detail->name ) }}">
                </div>
                <div class="row"  style="margin-top: 15px;">
               <div class="form-group col-md-4">
                    <select class="form-group form-control no-round city_id" name="city_id" id="city_id">
                        <option>Tỉnh/TP</option>
                        @foreach($cityList as $city)
                          <option value="{{$city->id}}"
                          @if(old('city_id', $detail->city_id ) == $city->id)
                          selected
                          @endif
                          >{{$city->name}}</option>
                        @endforeach
                    </select>
                </div>
                <?php 
                  $district_id = old('district_id', $detail->district_id);
                  $city_id = old('city_id', $detail->city_id);
                  ?>
                  <div class="form-group col-md-4">                    
                      <select class="form-control" name="district_id" id="district_id">
                        <option value="">Quận/Huyện</option>
                        <?php 
                        $districtList = App\Models\District::where('city_id', $city_id)->get();
                      
                      ?>
                          @foreach( $districtList as $value )
                          <option value="{{ $value->id }}"
                          {{ $district_id == $value->id ? "selected" : "" }}                           

                          >{{ $value->name }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group col-md-4">                    
                    <select class="form-control" name="ward_id" id="ward_id">
                      <option value="">Phường / Xã</option>
                      <?php 
                      $wardList = App\Models\Ward::where('district_id', $district_id)->get();
                      ?>
                      @foreach( $wardList as $value )
                      <option value="{{ $value->id }}"
                      {{ old('ward_id', $detail->ward_id) == $value->id ? "selected" : "" }}                           

                      >{{ $value->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>          
                <div class="clearfix"></div>
                 <div class="form-group" >
                  
                  <label>Địa chỉ <span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="address" id="address" value="{{ old('address', $detail->address) }}">
                </div>               
                 <div class="form-group" >
                  
                  <label>Số điện thoại</label>
                  <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $detail->phone) }}">
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
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">
<!-- Modal -->

@stop
@section('js')
<script type="text/javascript">
var h = screen.height;
var w = screen.width;
var left = (screen.width/2)-((w-300)/2);
var top = (screen.height/2)-((h-100)/2);
function openKCFinder_singleFile() {
      window.KCFinder = {};
      window.KCFinder.callBack = function(url) {
         $('#image_url').val(url);
         $('#thumbnail_image').attr('src', $('#app_url').val() + url);
          window.KCFinder = null;
      };
      window.open('{{ URL::asset("public/admin/dist/js/kcfinder/browse.php?type=images") }}', 'kcfinder_single','scrollbars=1,menubar=no,width='+ (w-300) +',height=' + (h-300) +',top=' + top+',left=' + left);
  }

  $(document).ready(function(){
      $(".select2").select2();      
      $('#btnUploadImage').click(function(){                
        openKCFinder_singleFile();
      });  
     
      
      
      $('#title').change(function(){
         var name = $.trim( $(this).val() );
         if( name != '' && $('#slug').val() == ''){
            $.ajax({
              url: $('#route_get_slug').val(),
              type: "POST",
              async: false,      
              data: {
                str : name
              },              
              success: function (response) {
                if( response.str ){                  
                  $('#slug').val( response.str );
                }                
              }
            });
         }
      });
     
    });
    
</script>
@stop
