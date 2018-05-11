@extends('frontend.layout')

@include('frontend.partials.meta')

@section('content')
<div class="content_kinh txt_center scroll_bar">
    <div class="relative">
        <div class="col-sm-12">
            @foreach($bookList as $book)
            <div class="col-sm-4" style="text-align: center;margin-bottom: 15px">
                <a href="{!! route('book', $book->id) !!}">
                    <img class="responsive" src ="{!! Helper::showImage($book->image_url) !!}" alt="{!! $book->name !!}"/>
                </a>
                <a style="display:block;font-size:14px;height:70px;overflow-y: hidden" class="book_name_content" href="{!! route('book', $book->id) !!}">
                {!! $book->name !!}</a>
            </div>            
            @endforeach
        </div>
    </div>
</div>
@stop