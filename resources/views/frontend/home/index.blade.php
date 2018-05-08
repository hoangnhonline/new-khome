@extends('frontend.layout')

@include('frontend.partials.meta')

@section('content')
<article>    
     <?php 
    $bannerArr = DB::table('banner')->where(['object_id' => 1, 'object_type' => 3])->orderBy('display_order', 'asc')->get();
    $deals = DB::table('product')->where(['is_sale' => 1])->count();
    ?>
    <section class="block-slide marg40">
        @if($bannerArr)
        <div class="owl-carousel owl-theme">            
            <?php $i = 0; ?>
            @foreach($bannerArr as $banner)
            <?php $i++; ?>
            <div class="item">
            @if($banner->ads_url !='')
            <a href="{{ $banner->ads_url }}" title="banner slide {{ $i }}">
            @endif
            <img src="{{ Helper::showImage($banner->image_url) }}" alt="banner slide {{ $i }}">
            @if($banner->ads_url !='')
            </a>
            @endif
            </div><!-- item-banner -->
            @endforeach
        </div>
        @endif
    </section>
    <section id="service-us" class="marg40">
        <div class="container">
            <div class="title-section text-center @if($isEdit) edit @endif" data-text="3">{!! $textList[3] !!}</div>
            <p class="text-center @if($isEdit) edit @endif" data-text="4">{!! $textList[4] !!}</p>
        </div>
        <div class="container clearfix">
            <div class="row marg-20">
                <div class="col-md-3 marg20">
                    <div class="index-sidebar">
                        <div class="nvn-title-side">
                            <i class="fa fa-star" aria-hidden="true"></i> Deals hot today
                        </div>
                        <div class="nvn-body-side">
                            <ul>
                                <li><a href="#">All deals</a><span>{{ $deals }}</span></li>
                                @foreach($cateParentList as $services)
                                    <?php
                                    $deals = DB::table('product')->where(['is_sale' => 1, 'parent_id' => $services->id])->count();
                                    ?>
                                    <li><a href="{{ route('cate-parent', $services->slug ) }}">{{ $services->name }}</a><span>{{ $deals }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 marg20">
                    @foreach($cateParentList as $services)
                        <div class="item-service">
                            <a href="{{ route('cate-parent', $services->slug ) }}" title="{!! $services->name !!}">
                                <div class="image"><img src="{{ Helper::showImage($services->image_url) }}" alt="{!! $services->name !!}"/></div>
                                <h2>{!! $services->name !!}</h2>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section><!-- End -->
    <?php 
    $bannerArr = DB::table('banner')->where(['object_id' => 5, 'object_type' => 3])->orderBy('display_order', 'asc')->get();   
    ?>
    <?php $i = 0; ?>
    @foreach($bannerArr as $banner)
    <?php $i++; ?>
    <section class="block-image marg40">
        <div class="container">
            @if($banner->ads_url !='')
            <a href="{{ $banner->ads_url }}" title="banner slide {{ $i }}">
            @endif
            <img src="{{ Helper::showImage($banner->image_url) }}" alt="banner slide {{ $i }}">
            @if($banner->ads_url !='')
            </a>
            @endif
        </div>
    </section>
    @endforeach
    <section id="welcome" class="marg40">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-section @if($isEdit) edit @endif" data-text="1" >{!! $textList[1] !!}</div>
                    <p data-text="2" @if($isEdit) class="edit" @endif>{!! $textList[2] !!}</p>
                </div>
                <!--<div class="col-md-6">
                    <iframe height="315" src="https://www.youtube.com/embed/{!! $settingArr['video_youtube_id'] !!}" frameborder="0" allowfullscreen></iframe>
                </div>-->
            </div>
        </div>
    </section><!-- End News -->
    <!--<section id="customer" class="marg40">
        <div class="container">
            <div class="owl-carousel">
             <?php 
             $bannerArr = DB::table('doitac')->orderBy('display_order', 'asc')->get();   
             ?>
             @foreach($bannerArr as $banner)
                <div class="item"><img src="{{ $banner->image_url }}" height="120" alt="{!! $banner->name !!}"></div>
                @endforeach
               
            </div>
        </div>
    </section>    -->
    
</article>
@stop
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        jQuery('.owl-carousel').owlCarousel({
            loop: true,
            margin: 0,
            nav: true,
            items: 1,
            dots: false
        });        
    });
</script>
@stop