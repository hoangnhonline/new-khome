@extends('frontend.layout')

@include('frontend.partials.meta')

@section('content')
<div class="content_kinh txt_center scroll_bar">
    <div class="relative">
        <img src="{{ URL::asset('public/assets/images/bia.jpg') }}" class="img-responsive hidden-xs" alt="Nền VNBET">
        <div class="col-sm-12 hidden-sx" style="position: absolute;top:700px">
            <div class="owl-bg">
                <ul class="owl-carousel owl-theme owl-style2" data-nav="true" data-dots="true" data-loop="true" data-margin="10" data-responsive='{"0":{"items":1},"480":{"items":2},"600":{"items":2},"768":{"items":3},"800":{"items":3},"992":{"items":4}}'>
                    @foreach($hotList as $book)
                    <li>
                        <a href="{!! route('book', $book->id) !!}">
                            <img src ="{!! Helper::showImage($book->image_url) !!}" alt="{!! $book->name !!}" />
                        </a>
                    </li>                     
                    @endforeach                      
                </ul>
            </div>                                  
        </div><!-- /.huongdan_xs -->
    </div>
</div>
@stop
@section('js')
@stop