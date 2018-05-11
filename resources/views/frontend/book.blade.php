@extends('frontend.layout')

@include('frontend.partials.meta')

@section('content')
<div class="content_kinh txt_center scroll_bar">
    <div id="content_mucluc">
        <h1 id="book-name" class="mucluc_sach">{!! $bookDetail->name !!}</h1>
        <div style="width:90%;margin:auto">
            @foreach($chapterList as $chapter)
            <h2 class="danhmuc_sach">
                <a class="mls_content" href="{!! route('chapter', $chapter->id) !!}">{!! $chapter->name !!}</a>
            </h2>                            
            @endforeach        
        </div>
    </div>
</div>
@stop