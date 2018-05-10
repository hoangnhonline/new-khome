@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{ trans('text.change_password') }}
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('text.dashboard') }}</a></li>      
      <li class="active">{{ trans('text.change_password') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">    
    <form role="form" method="POST" action="{{ route('account.store-pass') }}" id="formData">
    <div class="row">
      <!-- left column -->
       
      <div class="col-md-7">

        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">{{ trans('text.add_new') }}</h3>
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
                 
                 <!-- text input -->
                <div class="form-group">
                  <label>{{ trans('text.current_password') }}<span class="red-star">*</span></label>
                  <input type="password" class="form-control" name="old_pass" id="old_pass" value="">
                </div>
                 <div class="form-group">
                  <label>{{ trans('text.new_password') }} <span class="red-star">*</span></label>
                  <input type="password" class="form-control" name="new_pass" id="new_pass" value="">
                </div>  
                <div class="form-group">
                  <label>{{ trans('text.confirm_password') }} <span class="red-star">*</span></label>
                  <input type="password" class="form-control" name="new_pass_re" id="new_pass_re" value="">
                </div>                
                
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-default btn-sm" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
              <button type="submit" class="btn btn-primary btn-sm" id="btnSave">{{ trans('text.save') }}</button>             
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      
      <!--/.col (left) -->      
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
      $('#formData').submit(function(){
        $('#btnSave').hide();
        $('#btnLoading').show();
      });
    });
    
</script>
@stop
