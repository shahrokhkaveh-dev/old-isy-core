<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach($products as $product)
        <url>
            <loc>
                {{ route('user.product.show' , $product->slug) }}
            </loc>
            <lastmod>{{ $product->updated_at }}</lastmod>
            <changefreq>hourly</changefreq>
            <priority>0.8</priority>
            <image:image>
                <image:loc>
                    {{ asset($product->image) }}
                </image:loc>
                <image:caption>صنعت یار ایران</image:caption>
                <image:title>{{ $product->name }}</image:title>
            </image:image>
        </url>
    @endforeach
</urlset>
