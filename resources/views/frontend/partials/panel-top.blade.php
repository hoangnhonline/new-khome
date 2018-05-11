<div class="float_top_item item_top hidden-xs">
    <div class="float_content row">
        <div class="block_search">
            {!! trans('text.folder') !!}
            <select id="idML_Find" name="idML_Find">
                <option value="">{!! trans('text.choose') !!}</option>
                @foreach($folderList as $folder)
                <option value="{{ $folder->id }}">{!! $folder->name !!}</option>
                @endforeach
            </select>
            <input name="keyword" type="text" class="txt_input_search" id="textKeyword" value="{!! trans('text.keyword') !!}">
            <input type="submit" name="btnSumit" id="btnFind" value="{!! trans('text.search') !!}" class="searchbtn">
            <div class="clear">&nbsp;</div>
        </div>
        <div class="clearfix"></div>
        <!-- block_search -->
        <div id="result_find" class="row">
            <div class="block_content_float col-md-12">
                <div class="col-md-1 hidden-xs hidden-sm"></div>
                <div class="main_content_slide col-md-10" style="margin-left:30px"></div>
                <div class="col-md-1 hidden-xs hidden-sm"></div>
            </div>
        </div>
        <!-- result_find -->
        <div class="control_float">
            <a href="javascript:;" title="{!! trans('text.search') !!}" class="btn_control_float" id="btn_top">
            <img src="{{ URL::asset('public/assets/images/icon_up.gif') }}" alt="icon search">
            </a>
        </div>
    </div>
    <!-- float_content -->
</div><!-- item_top -->