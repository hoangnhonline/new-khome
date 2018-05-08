@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Danh mục trang chủ
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('hot-cate.index') }}">Danh mục trang chủ</a></li>
      <li class="active">Tạo mới</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('hot-cate.index') }}" style="margin-bottom:5px">Quay lại</a>    
    
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách</h3>
                    </div>
                    <!-- /.box-header -->
                    <button class="btn btn-info btn-sm btnAddMenu" data-parent="0" style="margin-top:5px;margin-left:10px">Thêm danh mục</button>
                    <form action="{{ route('hot-cate.store-order') }}" method="POST">
                      {!! csrf_field() !!}
                      <div class="box-body">
                        <button type="submit" class="btn btn-warning btn-sm">Cập nhật thứ tự</button>
                        

                          <table class="table table-bordered table-hover" id="table-list-data">
                              <tr>                                
                                  <th>Danh mục</th>
                                  <th width="1%;white-space:nowrap">Thao tác</th>
                              </tr>
                              <tbody>                              
                                  @foreach($items as $menu)
                                  
                                  <tr>                                                                    
                                    <td><input type="text" name="display_order[]" value="{{ $menu->display_order }}" class="form-control" style="width:40px; float:left;margin-right:10px">
                                    <input type="hidden" name="id[]" value="{{ $menu->id }}">
                                        <p style="font-weight:bold;padding-top:5px;margin-left:10px;">{{ $menu->title }}</p></td>
                                    <td width="1%" style="white-space:nowrap">                                                     
                                      <a onclick="return callDelete('{{ $menu->title }}','{{ route( 'hot-cate.destroy', [ 'id' => $menu->id ]) }}');" class="btn-sm btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                  </tr>                                        

                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                    </form>
                </div>
      </div>      

    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Thêm menu</h4>
        </div>
        <div class="modal-body" id="load-content-menu">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  #menuDefault li{
    cursor: no-drop;
  }
  .panel-title {font-weight: bold; text-transform:uppercase;}
  li {list-style: none;}
  li label{  font-weight: normal; }
  .loadMenu li{
    background-color: #CCC;
    display: block;
    clear: both;
    height: 40px;
    padding: 8px 10px 10px 0px;
    border-top:none !important;
    margin-bottom: 3px;
    cursor: move;
  }  
  .rm-div {
    cursor: pointer !important;
  }
  .loadMenu li.highlight{
    background-color: #28AA4A;
    color:#FFF;
  }
  #table-list-data tr td{    
    padding-bottom: 2px;
  }
</style>
@stop
@section('js')
<script type="text/javascript">
  $(document).on('click', 'input.menu_select', function(){
    var obj = $(this);
    $('#formMenu #title').val(obj.data('title'));    
    $('#formMenu #type').val(obj.data('type'));    
    $('#formMenu #object_id').val(obj.data('value'));
  });
  $(document).on('click', '.btnAddToMenuCustom', function(){
    var obj = $(this);
    $('#formMenu #title').val($('#title_custom').val());    
    $('#formMenu #type').val(6);    
    $('#formMenu #object_id').val(0);
  });
  function callDelete(name, url){  
      swal({
        title: 'Bạn muốn xóa "' + name +'"?',
        text: "Dữ liệu sẽ không thể phục hồi.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then(function() {
        location.href= url;
      })
      return flag;
    }
    $(document).ready(function(){ 

      $('.btnAddMenu').click(function(){
        var parent_id = $(this).data('parent');
        $.ajax({
          url : "{{ route('hot-cate.load-create') }}",
          type : 'GET',
          success : function(data){
            $('#load-content-menu').html(data);
            $('#myModal').modal('show');
          }
        });
      });   
       $( "#loadMenu" ).sortable({
          start: function (event, ui) {
                  ui.item.toggleClass("highlight");
                  
          },
          stop: function (event, ui) {
                  ui.item.toggleClass("highlight");
                  
          }
       });
       $(document).on('click', '.rm-div', function(){        
        if(confirm("Bạn có chắc chắn xóa ?")){
          $(this).parents('li').remove();
        }
       });
      $('.btnSelectAll').click(function(){
        $('#' + $(this).data('parent')  + ' input[type=checkbox]').prop('checked', true);
      });
      $('.btnAddToMenu').click(function(){
        var obj = $(this);
        $.ajax({
          url:  "",
          type : 'POST',
          data : $('#' + obj.data('parent') + ' :input').serialize(),
          success : function(data){
            $('#loadMenu').append(data);
            var rows = $('#loadMenu li');
            var liTmp = '';
            for (var i = 1; i< rows.length ; i++) {                
                $('#loadMenu li').eq(i-1).attr('id', 'row-' + i);
            }  
          }
        });
      });
      $('.btnAddToMenuCustom').click(function(){
        if($.trim($('#title').val()) != ''){
          var obj = $(this);
          $.ajax({
            url:  "",
            type : 'POST',
            data : $('#' + obj.data('parent') + ' :input').serialize(),
            success : function(data){
              $('#loadMenu').append(data);
              $('#title,').val('');
              var rows = $('#loadMenu li');
              var liTmp = '';
              for (var i = 1; i< rows.length ; i++) {                
                  $('#loadMenu li').eq(i-1).attr('id', 'row-' + i);
              }  
            }
          });
        }
      });
      
    });
</script>
@stop
