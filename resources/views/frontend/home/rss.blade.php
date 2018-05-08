<?xml version="1.0" ?>
<rss version="2.0">
    <channel>
        <title>{!! $settingArr['site_name'] !!}</title>
        <link>{!! env('APP_URL') !!}</link>
        <description>{!! $settingArr['site_description'] !!}</description>
        <language>vi_VN</language>
        @foreach($productList as $product)
        <item>
	        <title>{!! $product->title !!}</title>
	        <link>{{ route('product', [$product->slug, $product->id]) }}</link>
	        <description>{!! $product->description !!}</description>	
	        <pubDate>{!! date('d-m-Y H:i', strtotime($product->created_at)) !!}</pubDate>
        </item>
		@endforeach
		@foreach($articlesList as $product)
        <item>
	        <title>{!! $product->title !!}</title>
	        <link>{{ route('news-detail', [$product->slug, $product->id]) }}</link>
	        <description>{!! $product->description !!}</description>	
	        <pubDate>{!! date('d-m-Y H:i', strtotime($product->created_at)) !!}</pubDate>
        </item>
		@endforeach
    </channel>
</rss>