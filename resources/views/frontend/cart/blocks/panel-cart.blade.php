<div id="panel-cart">
  <div class="panel panel-default cart">
    <div class="panel-body">
      <div class="order"> <span class="title">{{ trans('text.don-hang') }}</span> <span class="title">( {{ array_sum($getlistProduct) }} {{ trans('text.san-pham') }} )</span> <a href="{{route('gio-hang')}}" class="btn btn-default btn-custom1">{{ trans('text.sua') }}</a> </div>
      <div class="product">
        <?php $total = $total_vnd = 0; ?>
        @foreach($arrProductInfo as $product)
        <?php 
        $price = ( $product->price_sale > 0 && $product->is_sale == 1) ?  $product->price_sale : $product->price;
        ?>
        <div class="item">
          <p class="title"><strong>{{ $getlistProduct[$product->id] }} x</strong><a href="" target="_blank">{{ $lang == 'vi' ? $product->name_vi : $product->name_en }}</a></p>
          @if($lang == 'en')
          <p class="price"> <span>
          <?php 
            echo number_format($getlistProduct[$product->id] * $price);            
          ?>$ </span> </p>
          @else
          <p class="price"> <span>
          <?php 
            echo number_format($getlistProduct[$product->id] * $product->price_vnd);            
          ?></span> </p>
          @endif
        </div>
        <?php                             
       
          $total += $getlistProduct[$product->id]*$price;  
        
          $total_vnd += $getlistProduct[$product->id]*($product->price_vnd);                             
     
        ?>
        @endforeach
      </div>
      
      @if($lang == 'en')
      <p class="total"> {{ trans('text.thanh-tien') }}: <span>{{number_format( $total )}}$ </span> </p>
      <p class="total"> {{ trans('text.thanh-tien') }} VND: <span>{{number_format( $total_vnd )}}</span> </p>
      @else
      <p class="total"> {{ trans('text.thanh-tien') }}: <span>{{number_format( $total_vnd )}}</span> </p>
      @endif
      <p class="text-right"> <i>({{ trans('text.da-bao-gom-vat') }})</i> </p>
    </div>
  </div>
</div><!--panel-cart-->