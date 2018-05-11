<div class="float_item item_left">
    <div class="float_content">
        <div class="ui-widget" id="siteMenuBar">
            <div class="tab_control">           
                <?php 
                $i = 0;
                ?>                     
                @foreach($folderList as $folder)
                <?php 
                $i++; 
                ?>
                <a href="{{ route('folder', $folder->id) }}" class="tabmenu @if($i == 1) active @endif">{!! $folder->name !!}</a>
                @endforeach
            </div>
            <div class="box_width_common">
                <div class="content_tab scroll_bar" style="height: 380px;">
                    <div class="ui-widget-header scroll-pane" id="menuContainer">
                        <div class="baosach">
                            @foreach($bookList as $book)
                            <p class="sach"><a href="{{ route('book', $book->id) }}">{!! $book->name !!}</a></p>
                            @if(isset($book_id) && $book_id == $book->id)
                            <div class="baodanhmuc">
                                @foreach($chapterList as $chapter)
                                <p style="color:brown;cursor:pointer;margin-top:5px;margin-bottom:5px;margin-left:20px" class="danhmuc">
                                    <a class="mls @if(isset($chapter_id) && $chapter_id == $chapter->id) bold @endif" com="mucluc" href="{!! route('chapter', $chapter->id) !!}" style="color:#903">{!! $chapter->name !!}</a>
                                </p>
                                @endforeach
                            </div>
                            @endif
                            @endforeach
                            
                        </div>
                        <!-- baosach -->
                    </div>
                    <!-- menuContainer -->
                </div>
                <!-- content_tab -->
            </div>
            <!-- box_width_common -->
        </div>
        <!-- siteMenuBar -->
        <div class="control_float_left">
            <a id="btn_left" class="btn_control_float" title="Show hide panel" href="javascript:;">
                <img alt="icon show hide" src="{{ URL::asset('public/assets/images/icon_ra.gif') }}">
            </a>
        </div>
    </div>
    <!-- float_content -->
</div><!-- float_content -->