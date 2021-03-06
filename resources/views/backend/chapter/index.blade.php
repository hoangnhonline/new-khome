@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
   {{ trans('text.chapter') }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('text.dashboard') }}</a></li>
    <li><a href="{{ route( 'chapter.index' ) }}">{{ trans('text.chapter') }}</a></li>
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
      <a href="{{ route('chapter.create', ['folder_id' => $folder_id, 'book_id' => $book_id]) }}" class="btn btn-info btn-sm" style="margin-bottom:5px">{{ trans('text.add_new') }}</a>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">{{ trans('text.filter') }}</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" id="searchForm" role="form" method="GET" action="{{ route('chapter.index') }}">
           
          
            
            <div class="form-group">
              <label for="email">&nbsp;&nbsp;{{ trans('text.folder') }}</label>
              <select class="form-control" name="folder_id" id="folder_id">
                <option value="">{{ trans('text.choose') }}</option>
                @foreach( $folderList as $value )
                <option value="{{ $value->id }}" {{ $value->id == $folder_id ? "selected" : "" }}>{{ $value->name }}</option>
                @endforeach
              </select>
            </div>
              <div class="form-group">
              <label for="email">&nbsp;&nbsp;{{ trans('text.book') }}</label>

              <select class="form-control" name="book_id" id="book_id">
                <option value="">{{ trans('text.choose') }}</option>
                @foreach( $bookList as $value )
                <option value="{{ $value->id }}" {{ $value->id == $book_id ? "selected" : "" }}>{{ $value->name }}</option>
                @endforeach
              </select>
            </div>                                  
            <button type="submit" style="margin-top:-5px" class="btn btn-primary btn-sm">{{ trans('text.filter') }}</button>
          </form>         
        </div>
      </div>
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('text.the_list') }} ({{$items->count()}})</h3>
        </div>          
        <!-- /.box-header -->
        <div class="box-body">

          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>
              <th>{{ trans('text.name') }}</th>
              <th>{{ trans('text.book') }}</th>              
              <th style="text-align:center">{{ trans('text.page') }}</th>              
              <th style="width:1%;white-space:nowrap">{{ trans('text.action') }}</th>
            </tr>
            <tbody>
            @if( $items->count() > 0 )
              <?php $i = 0; ?>
              @foreach( $items as $item )
                <?php $i ++;

                 ?>
              <tr id="row-{{ $item->id }}">
                <td><span class="order">{{ $i }}</span></td>    
                
                <td>                  
                  <a href="{{ route( 'chapter.edit', [ 'id' => $item->id ]) }}">{{ $item->name }}</a>
                </td>
                <td>{{ $item->book->name }}</td>                
                <td style="text-align:center"><a class="btn btn-info btn-sm" href="{{ route('page.index', ['chapter_id' => $item->id, 'folder_id' => $item->folder_id, 'book_id' => $item->book_id])}}">{{ $item->pages->count() }}</a></td>                
                <td style="white-space:nowrap; text-align:right">                           
                  <a href="{{ route( 'chapter.edit', [ 'id' => $item->id ]) }}" class="btn-sm btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></a>                 
                  @if( $item->pages->count() == 0)
                  <a onclick="return callDelete('{{ $item->name }}','{{ route( 'chapter.destroy', [ 'id' => $item->id ]) }}');" class="btn-sm btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                  @endif
                </td>
              </tr> 
              @endforeach
            @else
            <tr>
              <td colspan="5">{{ trans('text.no_data') }}</td>
            </tr>
            @endif

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
function callDelete(name, url){  
  swal({
    title: '{{ trans('text.confirm') }}',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '{{ trans('text.yes') }}'
  }).then(function() {
    location.href= url;
  })
  return flag;
}
$(document).ready(function(){  
  $('#folder_id').change(function(){
    
    $('#book_id').val('');
    $('#searchForm').submit();
  });
  $('#book_id').change(function(){
    $('#created_user').val('');
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
            updateOrder("loai_sp", strOrder);
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