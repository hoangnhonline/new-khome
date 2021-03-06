@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Book
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('text.dashboard') }}</a></li>
    <li><a href="{{ route( 'book.index' ) }}">Book</a></li>
    <li class="active">{{ trans('text.the_list') }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
      <p class="alert alert-info" >{{ Session::get('message') }}</p>
      @endif
      <a href="{{ route('book.create', ['folder_id' => $arrSearch['folder_id'], 'author_id' => $arrSearch['author_id']]) }}" class="btn btn-info btn-sm" style="margin-bottom:5px">{{ trans('text.add_new') }}</a>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Bộ lọc</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" id="searchForm" role="form" method="GET" action="{{ route('book.index') }}">
           
          
            
            <div class="form-group">
              <label for="email">Folder</label>
              <select class="form-control" name="folder_id" id="folder_id">
                <option value="">--All--</option>
                @foreach( $folderList as $value )
                <option value="{{ $value->id }}" {{ $value->id == $arrSearch['folder_id'] ? "selected" : "" }}>{{ $value->name }}</option>
                @endforeach
              </select>
            </div>
              <div class="form-group">
              <label for="email">Author</label>

              <select class="form-control" name="author_id" id="author_id">
                <option value="">--All--</option>
                @foreach( $authorList as $value )
                <option value="{{ $value->id }}" {{ $value->id == $arrSearch['author_id'] ? "selected" : "" }}>{{ $value->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="email">Created user</label>

              <select class="form-control" name="created_user" id="created_user">
                <option value="">--All--</option>
                @foreach( $userList as $value )
                <option value="{{ $value->id }}" {{ $value->id == $arrSearch['created_user'] ? "selected" : "" }}>{{ $value->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="email">ID/Name</label>
              <input type="text" class="form-control" name="keyword" value="{{ $arrSearch['keyword'] }}">
            </div>                       
            <button type="submit" style="margin-top:-5px" class="btn btn-primary btn-sm">Filter</button>
          </form>         
        </div>
      </div>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('text.the_list') }} ( {{ $items->total() }} sản phẩm )</h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
          <div style="text-align:center">
           {{ $items->appends( $arrSearch )->links() }}
          </div>  
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>
              
              <th style="width: 1%;white-space:nowrap">{{ trans('text.order') }}</th>
              
              <th width="210px">Hình ảnh</th>
              <th style="text-align:center">Thông tin sản phẩm</th>                              
              <th width="1%;white-space:nowrap">{{ trans('text.action') }}</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++; 

                ?>
              <tr id="row-{{ $item->id }}">
                <td><span class="order">{{ $i }}</span></td>
                
                <td style="vertical-align:middle;text-align:center">
                  <img src="{{ URL::asset('backend/dist/img/move.png')}}" class="move img-thumbnail" alt="{{ trans('text.{{ trans('text.author') }}') }} thứ tự"/>
                </td>
                
                <td>
                  <img class="img-thumbnail lazy" width="206" data-original="{{ $item->image_url ? Helper::showImage($item->image_url) : URL::asset('backend/dist/img/no-image.jpg') }}" alt="{{ $item->name }}" title="{{ $item->name }}" />
                </td>
                <td>                  
                  <a style="color:#333;font-weight:bold" href="{{ route( 'book.edit', [ 'id' => $item->id ]) }}">{{ $item->name }}</a> &nbsp; @if( $item->is_hot == 1 )
                  <label class="label label-danger">HOT</label>
                  @endif<br />
                  <strong style="color:#337ab7;font-style:italic"> {{ $item->cate_parent_name }} / {{ $item->cate_name }}</strong>
                 <p style="margin-top:10px">
                    @if( $item->is_sale == 1)
                   <b style="color:red">                  
                    {{ number_format($item->price_sale) }}
                   </b>
                   <span style="text-decoration: line-through">
                    {{ number_format($item->price) }}  
                    </span>
                    @else
                    <b style="color:red">                  
                    {{ number_format($item->price) }}
                   </b>
                    @endif 
                  </p>
                  
                </td>
                <td style="white-space:nowrap; text-align:right">
                  <a class="btn btn-default btn-sm" href="{{ route('product', [ $item->slug, $item->product_id ]) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> Xem</a>                 
                  <a href="{{ route( 'book.edit', [ 'id' => $item->id ]) }}" class="btn btn-warning btn-sm">{{ trans('text.modify') }}</a>                 

                  <a onclick="return callDelete('{{ $item->name }}','{{ route( 'book.destroy', [ 'id' => $item->id ]) }}');" class="btn btn-danger btn-sm">Xóa</a>

                </td>
              </tr> 
              @endforeach
            @else
            <tr>
              <td colspan="9">{{ trans('text.no_data') }}</td>
            </tr>
            @endif

          </tbody>
          </table>
          <div style="text-align:center">
           {{ $items->appends( $arrSearch )->links() }}
          </div>  
        </div>        
      </div>
      <!-- /.box -->     
    </div>
    <!-- /.col -->  
  </div> 
</section>
<!-- /.content -->
</div>
<style type="text/css">
#searchForm div{
  margin-right: 7px;
}
</style>
@stop
@section('js')
<script type="text/javascript">
function callDelete(name, url){  
  swal({
    title: '{{ trans('text.confirm') }}',
    text: "Dữ liệu sẽ không thể phục hồi.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '{{ trans('text.yess') }}'
  }).then(function() {
    location.href= url;
  })
  return flag;
}
$(document).ready(function(){
  $('input.submitForm').click(function(){
    var obj = $(this);
    if(obj.prop('checked') == true){
      obj.val(1);      
    }else{
      obj.val(0);
    } 
    obj.parent().parent().parent().submit(); 
  });
  
  $('#folder_id').change(function(){
    $('#author_id').val('');
    $('#searchForm').submit();
  });
  $('#author_id').change(function(){
    $('#created_user').val('');
    $('#searchForm').submit();
  });
  $('#created_user').change(function(){    
    $('#searchForm').submit();
  });
  $('#table-list-data tbody').sortable({
        placeholder: 'placeholder',
        handle: ".move",
        start: function (event, ui) {
                ui.item.toggleClass("highlight");
        },
        stop: function (event, ui) {
                ui.item.toggleClass("highlight");
        },          
        axis: "y",
        update: function() {
            var rows = $('#table-list-data tbody tr');
            var strOrder = '';
            var strTemp = '';
            for (var i=0; i<rows.length; i++) {
                strTemp = rows[i].id;
                strOrder += strTemp.replace('row-','') + ";";
            }     
            updateOrder("san_pham", strOrder);
        }
    });
});
function updateOrder(table, strOrder){
  $.ajax({
      url: $('#route_update_order').val(),
      type: "POST",
      async: false,
      data: {          
          str_order : strOrder,
          table : table
      },
      success: function(data){
          var countRow = $('#table-list-data tbody tr span.order').length;
          for(var i = 0 ; i < countRow ; i ++ ){
              $('span.order').eq(i).html(i+1);
          }                        
      }
  });
}
</script>
@stop