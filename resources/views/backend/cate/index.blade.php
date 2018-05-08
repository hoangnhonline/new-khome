@extends('backend.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Danh mục cha 
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route( 'cate.index' ) }}">Danh mục cha</a></li>
            <li class="active">Danh sách</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @if(Session::has('message'))
                <p class="alert alert-info" >{{ Session::get('message') }}</p>
                @endif
                <a href="{{ route('cate.create', ['parent_id' => $parent_id]) }}" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
                <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title">Bộ lọc</h3>
                      </div>
                      <div class="panel-body">
                        <form class="form-inline" id="searchForm" role="form" method="GET" action="{{ route('cate.index') }}">                           
                            <div class="form-group">
                                <select class="form-control" name="parent_id" id="parent_id">
                                    <option value="">--Loại sản phẩm--</option>                                   
                                    @foreach( $cateParentList as $value )
                                    <option value="{{ $value->id }}"
                                    {{ $parent_id == $value->id ? "selected" : "" }}                        
                                    >{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">              
                                <input type="text" placeholder="Tên" class="form-control" name="name" value="{{ $name }}" >
                            </div>                            
                            <div class="form-group">
                                <div class="checkbox">
                                    <label style="color:red; font-weight:bold">
                                    <input type="checkbox" name="is_hot" id="is_hot" value="1" {{ $is_hot == 1 ? "checked" : "" }}>
                                    HOT
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
                        </form>
                        </div></div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Danh sách</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table class="table table-bordered" id="table-list-data">
                            <tr>
                                <th style="width: 1%">#</th>
                                <th style="width: 1%;white-space:nowrap">Thứ tự</th>
                                <th width="150">Hình ảnh</th>
                                <th>Tên</th>
                                <th width="1%;white-space:nowrap">Thao tác</th>
                            </tr>
                            <tbody>
                                @if( $items->count() > 0 )
                                <?php $i = 0; ?>
                                @foreach( $items as $item )
                                <?php $i ++; ?>
                                <tr id="row-{{ $item->id }}">
                                    <td><span class="order">{{ $i }}</span></td>
                                    <td style="vertical-align:middle;text-align:center">
                                        <img src="{{ URL::asset('public/admin/dist/img/move.png')}}" class="move img-thumbnail" alt="Cập nhật thứ tự"/>
                                    </td>
                                    <td>
                                      <img class="img-thumbnail lazy" width="100" data-original="{{ $item->image_url ? Helper::showImage($item->image_url) : URL::asset('public/admin/dist/img/no-image.jpg') }}" alt="Nổi bật" title="Nổi bật" />
                                    </td>
                                    <td>
                                        <a href="{{ route( 'cate.edit', [ 'id' => $item->id ]) }}">{{ $item->name }}</a>
                                         @if( $item->is_hot == 1 )
                                          <label class="label label-danger">HOT</label>
                                          @endif
                                          @if($item->is_widget == 1)
                                          <label class="label label-primary">WIDGET</label>
                                          @endif
                                        <p>{{ $item->description }}</p>
                                    </td>                                   
                                    <td style="white-space:nowrap; text-align:right">
                                        <a class="btn btn-default btn-sm" href="{{ route('cate', [$item->cateParent->slug, $item->slug] ) }}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> Xem</a>                
                                        <a href="{{ route( 'cate.edit', [ 'id' => $item->id ]) }}" class="btn-sm btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></a>                 
                                        @if( $item->product->count() == 0)
                                        <a onclick="return callDelete('{{ $item->name }}','{{ route( 'cate.destroy', [ 'id' => $item->id ]) }}');" class="btn-sm btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="9">Không có dữ liệu.</td>
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
        $('#parent_id').change(function(){    
          $('#searchForm').submit();
        });  
        $('#type_id').change(function(){
            $('#parent_id').val('');
            $('#searchForm').submit();
        });
        $('#is_hot').change(function(){
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
                updateOrder("cate", strOrder);
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