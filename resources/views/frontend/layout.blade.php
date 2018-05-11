<!DOCTYPE html>
<!--[if lt IE 7 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie9 lte9"><![endif]-->
<!--[if IE 10 ]><html dir="ltr" lang="vi-VN" class="no-js ie ie10 lte10"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="vn">
<head>
    <title>@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="content-language" content="vi"/>
    <meta name="description" content="@yield('site_description')"/>
    <meta name="keywords" content="@yield('site_keywords')"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>       
    <link rel="canonical" href="{{ url()->current() }}"/>            
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('site_description')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="khmerbeta.org" />
    <?php $socialImage = isset($socialImage) ? $socialImage : $settingArr['banner']; ?>
    <meta property="og:image" content="{{ Helper::showImage($socialImage) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="@yield('site_description')" />
    <meta name="twitter:title" content="@yield('title')" />     
    <meta name="twitter:image" content="{{ Helper::showImage($socialImage) }}" />
    <link rel="icon" href="{{ URL::asset('public/assets/favicon.ico') }}" type="image/x-icon"> 

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/css/style.css') }}">
    <!-- ===== Responsive CSS ===== -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('public/assets/css/responsive.css') }}">

    <!-- HTML5 Shim and Respond.js') }}" IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js') }}" doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <link href='css/animations-ie-fix.css' rel='stylesheet'>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}""></script>
        <script src="https://oss.maxcdn.com/libs/respond.js') }}"/1.4.2/respond.min.js') }}""></script>
    <![endif]-->
</head>
<body>

    <div id="wrapper_vnbet">       

        <div class="container visible_xs hide-bg-xs"></div>
        <div class="container main_vnbet">
            <div class="row">
                <div class="col-md-12" id="top_rs">
                    <div class="logo_site">
                        <a href="{{ route('home') }}"><img src="{{ URL::asset('public/assets/images/logo.jpg') }}" alt="LOGO VNBET"></a>
                    </div>
                </div><!-- /#top_rs -->
                <div class="col-md-1 hidden-xs hidden-sm" id="left_rs"></div><!-- /#left_rs -->
                <div class="col-md-10">
                    @include('frontend.partials.header-search')
                    <div id="center_rs" class="fck_content">
                        @yield('content')
                    </div>
                </div><!-- /.col-md-10 -->
                <div class="col-md-1 hidden-xs hidden-sm" id="right_rs"></div><!-- /#right_rs -->
            </div>
            <div class="row" id="book_name">
                <div class="col-md-12">
                    <div id="box_name_kinh" class="col-md-12 name_kinh_bottom">
                        Thư viện điện tử Kinh sách Phật giáo tiếng Việt
                    </div>
                </div>
            </div>
        </div><!-- /.container .main_vnbet -->
    </div><!-- wrapper vnbet -->

    @include('frontend.partials.panel-left')

    @include('frontend.partials.panel-top')

    <div class="float_top_item item_bottom hidden-xs">
        <div class="float_content">
            <div id="wrapper_phapam">
                <div id="list_phap_am">
                    <ul class="owl-carousel owl-theme owl-style2" data-nav="true" data-dots="false" data-loop="true" data-margin="10" data-responsive='{"0":{"items":1},"480":{"items":2},"600":{"items":2},"768":{"items":3},"800":{"items":3},"992":{"items":4}}'>
                        <li>
                            <img src="{{ URL::asset('public/assets/images/album/kinhtrungbotap1.png') }}" alt="Giải Trình Ý Nghĩa Vu Lan" />
                            <span class="title_phapam">Kinh Trường Bộ tập 1</span>
                        </li>
                        <li>
                            <img src="{{ URL::asset('public/assets/images/album/kinhtrungbotap1.png') }}" alt="Tư Tưởng Kinh Kim Cương" />
                            <span class="title_phapam">Kinh Trường Bộ tập 1</span>
                        </li>
                        <li>
                            <img src="{{ URL::asset('public/assets/images/album/kinhtrungbotap1.png') }}" alt="Việc Lớn Nhất Của Đời Người" />
                            <span class="title_phapam">Kinh Trường Bộ tập 1</span>
                        </li>
                        <li>
                            <img src="{{ URL::asset('public/assets/images/album/kinhtrungbotap1.png') }}" alt="Phương Pháp Hành Trì Chuẩn Đề Đà La Ni" />
                            <span class="title_phapam">Kinh Trường Bộ tập 1</span>
                        </li>
                    </ul>
                </div>              
                <!-- list_phap_am -->
                <span class="hidden" id="nut_hien_list">Xem danh sách pháp âm</span>
                <span class="hidden" id="dang_nghe">Pháp âm đang nghe</span>
                <div class="hidden" id="hien_phap_am"></div>
            </div>
            <a id="btn_bottom" class="btn_control_float" title="Nghe pháp âm" href="javascript:void(0)">
                <img alt="icon ẩn hiện nghe pháp âm" src="{{ URL::asset('public/assets/images/icon_up.gif') }}">
            </a>
        </div>
    </div>    
    <!-- ===== JS ===== -->
    <script src="{{ URL::asset('public/assets/js/jquery.min.js') }}"></script>    
    <!-- ===== JS Bootstrap ===== -->
    <script src="{{ URL::asset('public/assets/lib/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/home.js') }}"></script>
    <!-- ===== carousel ===== -->
    <script src="{{ URL::asset('public/assets/lib/owl.carousel/owl.carousel.min.js') }}"></script>
    <!-- ===== Js Common ===== -->
    <script src="{{ URL::asset('public/assets/js/common.js') }}"></script>
    <script src="{{ URL::asset('public/assets/js/jcarousel.js') }}"></script>
    @yield('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.parent-obj').change(function(){  
                var obj = $(this);
                $.ajax({
                    url : "{{ route('get-child') }}",
                    data : {
                        mod : obj.data('mod'),
                        col : obj.data('col'),              
                        id : obj.val()
                    },
                    type : 'POST',
                    dataType : 'html',
                    success : function(data){
                        $('#' + obj.data('child')).html(data);              
                    }
                });
            });
            @if(isset($folder_id))
            $('#folder_id').val({{ $folder_id }});
            @endif
            @if(isset($book_id))
            $('#book_id').val({{ $book_id }});
            @endif
            @if(isset($chapter_id))
            $('#chapter_id').val({{ $chapter_id }});
            @endif
            @if(isset($page_id))
            $('#page_id').val({{ $page_id }});
            @endif
            $('#btnSumit').click(function(){
                var page_id = $('#page_id').val();
                var chapter_id = $('#chapter_id').val();
                var book_id = $('#book_id').val();
                var folder_id = $('#folder_id').val();
                if(page_id > 0){                    
                    var chapter_id = $('#page_id').find(":selected").data('chapter');
                    location.href = '{{ config('app.url') }}' + '/chapter-' + chapter_id + ".html#page-" + page_id;
                    return false;
                }
                if(chapter_id > 0){
                    location.href = '{{ config('app.url') }}' + '/chapter-' + chapter_id + ".html";return false;
                }
                if(book_id > 0){
                    location.href = '{{ config('app.url') }}' + '/book-' + book_id + ".html";return false;
                }
                if(folder_id > 0){
                    location.href = '{{ config('app.url') }}' + '/folder-' + folder_id + ".html";return false;
                }
            });
        });
    </script>
</body>

</html>