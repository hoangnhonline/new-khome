<div class="col-sm-3 col-xs-12 block-col-right">
      <div class="block-sidebar">
        <div class="block-module block-news-sidebar">
          <div class="block-title">
            <h2>
              <i class="fa fa-home"></i>
              TIN LIÊN QUAN
            </h2>
          </div>
          <div class="block-content">
            <ul class="list">
              @foreach($otherList as $articles)
              <li class="item">
                <div class="thumb">
                  <a href="{{ route('news-detail', ['slug' => $articles->slug, 'id' => $articles->id]) }}"><img class="lazy" data-original="{{ $articles->image_url ? Helper::showImage($articles->image_url) : URL::asset('public/assets/images/no-img.png') }}" alt="{!! $articles->title !!}"></a>
                </div>
                <div class="description">
                  <h2>{!! $articles->title !!}</h2>
                </div>
              </li>
              @endforeach   
            </ul>
          </div>
        </div>
        <div class="block-module block-news-sidebar">
          <div class="block-title">
            <h2>
              <i class="fa fa-home"></i>
              DỰ ÁN NỔI BẬT
            </h2>
          </div>
          <div class="block-content">
            <ul class="list">
              
            </ul>
          </div>
        </div>
      </div>
    </div><!-- /block-col-right -->