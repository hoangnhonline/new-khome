@extends('backend.layout')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
   {{ trans('text.page') }}
   @if($chapter_id > 0)
   : <strong><i>{{ $chapterDetail->folder->name }}</i></strong> / <strong><i>{{ $chapterDetail->book->name }}</i></strong> / <strong><i>{{ $chapterDetail->name }}</i></strong>
   @endif
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> {{ trans('text.dashboard') }}</a></li>
    <li><a href="{{ route( 'page.index' ) }}">{{ trans('text.page') }}</a></li>
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
     
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">{{ trans('text.filter') }}</h3>
        </div>
        <div class="panel-body">
          <form class="form-inline" id="searchForm" role="form" method="GET" action="{{ route('page.index') }}">
           
          
            
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
            <div class="form-group">
              <label for="email">&nbsp;&nbsp;{{ trans('text.chapter') }}</label>

              <select class="form-control" name="chapter_id" id="chapter_id">
                <option value="">{{ trans('text.choose') }}</option>
                @foreach( $chapterList as $value )
                <option value="{{ $value->id }}" {{ $value->id == $chapter_id ? "selected" : "" }}>{{ $value->name }}</option>
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
          @if($chapter_id > 0)
           <a href="{{ route('page.create', ['chapter_id' => $chapter_id]) }}" class="btn btn-info btn-sm" style="margin-bottom:5px">{{ trans('text.add_new') }}</a>
           @endif
          <table class="table table-bordered" id="table-list-data">
            <tr>
              <th style="width: 1%">#</th>
              <th width="150px">ID</th>
              <th>{{ trans('text.chapter') }}</th>              
              <th>{{ trans('text.book') }}</th>       
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
                  <a href="{{ route( 'page.edit', [ 'id' => $item->id ]) }}">{{ $item->id }}</a>
                </td>
                <td>{{ $item->chapter->name }}</td>
                <td>{{ $item->book->name }}</td>
                <td style="white-space:nowrap; text-align:right">                           
                  <a href="{{ route( 'page.edit', [ 'id' => $item->id ]) }}" class="btn-sm btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></a>                                   
                  <a onclick="return callDelete('{{ $item->name }}','{{ route( 'page.destroy', [ 'id' => $item->id ]) }}');" class="btn-sm btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>                  
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
    $('#chapter_id').val('');
    $('#searchForm').submit();
  });
  $('#book_id').change(function(){
    $('#chapter_id').val('');
    $('#searchForm').submit();
  });
  $('#chapter_id').change(function(){    
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