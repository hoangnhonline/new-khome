@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{ trans('text.book') }}     
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('text.dashboard') }}</a></li>
      <li><a href="{{ route('book.index') }}">{{ trans('text.book') }}</a></li>
      <li class="active">{{ trans('text.modify') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('book.index') }}" style="margin-bottom:5px">{{ trans('text.back') }}</a>   
    <div class="row">
      <!-- left column -->

      <div class="col-md-7">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            {{ trans('text.modify') }}
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form role="form" method="POST" action="{{ route('book.update') }}">
            {!! csrf_field() !!}
            <input type="hidden" name="id" value="{{ $detail->id }}">
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
               <!-- text input -->
              <div class="form-group">
                    <label for="email">{{ trans('text.folder') }} <span class="red-star">*</span></label>
                    <select class="form-control req" name="folder_id" id="folder_id">
                        <option value="">-- {{ trans('text.choose') }} --</option>
                        @foreach( $folderList as $value )
                        <option value="{{ $value->id }}"
                        {{ old('folder_id', $detail->folder_id) == $value->id ? "selected" : "" }}                           
                        >{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>     
                 <!-- text input -->
                <div class="form-group">
                  <label>{{ trans('text.name') }}<span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $detail->name) }}">
                </div>
                <div class="form-group">
                    <label for="email">{{ trans('text.author') }} <span class="red-star">*</span></label>
                    <select class="form-control req" name="author_id" id="author_id">
                        <option value="">-- {{ trans('text.choose') }} --</option>
                        @foreach( $authorList as $value )
                        <option value="{{ $value->id }}"
                        {{ old('author_id', $detail->author_id) == $value->id ? "selected" : "" }}                           
                        >{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div> 
                <div class="form-group">
                  <label>{{ trans('text.publishing_company') }}</label>
                  <input type="text" class="form-control" name="publish_company" id="publish_company" value="{{ old('publish_company', $detail->publish_company) }}">
                </div>
                <div class="form-group">
                  <label>{{ trans('text.publishing_year') }}</label>
                  <input type="text" class="form-control" name="publish_year" id="publish_year" value="{{ old('publish_year', $detail->publish_year) }}">
                </div>
                <div class="form-group" style="margin-top:10px">  
                <label class="col-md-3 row">{{ trans('text.cover') }} (190 x 268px)</label>    
                <div class="col-md-9">
                    <img id="thumbnail_image" src="{{ $detail->image_url ? Helper::showImage($detail->image_url ) : URL::asset('public/admin/dist/img/img.png') }}" class="img-thumbnail" width="145" height="85">
                    
                    <input type="file" id="file-image" style="display:none" />
                 
                    <button class="btn btn-default btn-sm" id="btnUploadImage" type="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> {{ trans('text.upload') }}</button>
                    <input type="hidden" name="image_url" id="image_url" value="{{ old('image_url', $detail->image_url) }}"/>  
                  </div>
              </div>
              
            </div>         
              
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">{{ trans('text.save') }}</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('book.index')}}">{{ trans('text.cancel') }}</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-5">
        
      <!--/.col (left) -->      
    </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<style type="text/css">
  .checkbox+.checkbox, .radio+.radio{
    margin-top: 10px !important;
  }
</style>
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">
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
$(document).on('click', '.remove-image', function(){
  if( confirm ("Bạn có chắc chắn không ?")){
    $(this).parents('.col-md-3').remove();
  }
});
    $(document).ready(function(){
      $('#btnUploadImage').click(function(){        
        openKCFinder_singleFile();
      }); 
      $('#name').change(function(){
         var name = $.trim( $(this).val() );
         
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
       
      });

    });
    
</script>
@stop
