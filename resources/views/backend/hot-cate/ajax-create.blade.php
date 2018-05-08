<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">              
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Danh mục sản phẩm
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        <ul>
        <?php 
          $parentList = DB::table('cate_parent')->orderBy('display_order')->get();

          ?>
          @foreach($parentList as $parent)
          <?php 
              $cateList = DB::table('cate')->where('parent_id', $parent->id)->orderBy('display_order')->get();

              ?>
          <li>
            <label>
            <input type="radio" name="menu_select" data-title="{{ $parent->name }}" data-link="{{ route('cate-parent', $parent->slug) }}" data-value="{{ $parent->id }}" data-type="1" class="menu_select"> {{ $parent->name }}
            </label>       
              @if($cateList)

            <ul class="level0 submenu">     
              @foreach($cateList as $cate)
              
              <li class="level1">
               <label> <input type="radio" name="menu_select" data-title="{{ $cate->name }}" data-link="{{ route('cate', [$parent->slug, $cate->slug]) }}" data-value="{{ $cate->id }}" data-type="2" class="menu_select">{!! $cate->name !!}</label>                
               
              </li>
              @endforeach
            </ul>
            
            @endif                  
          </li>
          @endforeach
        </ul>                             
      </div>
    </div>
  </div> 
</div>  
<form method="POST" action="{{ route('hot-cate.store')}}" id="formMenu">
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Hiển thị</h3>
  </div>
  <!-- /.box-header -->               
    {!! csrf_field() !!}

    <div class="box-body">
         <!-- text input -->
        <div class="form-group">
          <label>Text hiển thị <span class="red-star">*</span></label>
          <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
        </div>                   
        <input type="hidden" name="type" id="type" value="">        
        <input type="hidden" name="object_id" id="object_id" value="">
    </div>
    <!-- /.box-body -->                
    <div class="box-footer">
      <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
      <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" data-dismiss="modal">Hủy</a>
    </div>
    
</div>
</form>
