<div class="row hidden-xs" id="box_search">
    <div class="col-md-2">
        {!! trans('text.folder') !!}
        <select id="folder_id" name="folder_id" style="width:70px" class="parent-obj" data-col="folder_id" data-child="book_id" data-mod="book">
            <option value="">{!! trans('text.choose') !!}</option>
            @foreach($folderList as $folder)
            <option value="{{ $folder->id }}">{!! $folder->name !!}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{!! trans('text.book') !!}
        <select id="book_id" name="book_id" class="parent-obj" data-col="book_id" data-child="chapter_id" data-mod="chapter">
            <option value="">{!! trans('text.choose') !!}</option>
            @if(isset($folder_id))
                @foreach($bookList as $book)
                <option value="{{ $book->id }}">{!! $book->name !!}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="col-md-3">
        &nbsp;&nbsp;{!! trans('text.chapter') !!}
        <select id="chapter_id" name="chapter_id" class="parent-obj" data-col="chapter_id" data-child="page_id" data-mod="page">
            <option value="">{!! trans('text.choose') !!}</option>
             @if(isset($book_id))
                @foreach($chapterList as $chapter)
                <option value="{{ $chapter->id }}">{!! $chapter->name !!}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="col-md-3">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{!! trans('text.page') !!}
        <select id="page_id" name="page_id">
            <option value="">{!! trans('text.choose') !!}</option>
            @if(isset($chapter_id))
                @foreach($pageList as $page)
                <option value="{{ $page->id }}" data-chapter="{{ $chapter_id }}">{!! $page->id !!}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="col-md-1">          
        <span class="hidden-lg">&nbsp;</span>
        <input type="button" id="btnSumit" value="{!! trans('text.view') !!}" name="btnSumit">
    </div>
</div><!-- /#box_search -->