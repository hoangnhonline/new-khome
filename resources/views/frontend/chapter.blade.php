@extends('frontend.layout')

@include('frontend.partials.meta')

@section('content')
<div class="content_kinh txt_cente scroll_bar">
    @foreach($pageList as $page)
    <div class="content_page" thutu="{{ $page->id }}" id="page-{{ $page->id }}">
        {!! $page->content !!}        
    </div>
    <p class="device_page">* {!! trans('text.page') !!} {{ $page->id }} *<br>
        <img src="{{ URL::asset('public/assets/images/hr.png') }}" style="clear:both" alt="device">
    </p>   
    @endforeach 
</div>
@stop