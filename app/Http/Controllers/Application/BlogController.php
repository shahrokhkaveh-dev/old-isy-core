<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Services\Application\ApplicationService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blogs(): \Illuminate\Http\JsonResponse
    {
        $articles = News::orderBy('id','desc')->paginate(10);
        return ApplicationService::responseFormat($articles->toArray());
    }

    public function article($id): \Illuminate\Http\JsonResponse
    {
        $article = News::find($id);
        return ApplicationService::responseFormat(['article' => $article]);
    }
}
