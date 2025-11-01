<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function sitemap()
    {
        $products=Product::all();
        return response()->view('sitemap',compact('products'))->header('Content-Type','text/xml');
    }
}
