<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jcobhams\NewsApi\NewsApi;
use Illuminate\Support\Str;

class NewsApiController extends Controller
{
  protected $newsapi;

  public function __construct()
  {
    $this->newsapi = new NewsApi(env('NEWS_API_KEY'));
  }

  public function index(Request $request)
  {
    $news = $this->newsapi->getTopHeadlines($request->q, $request->sources, $request->country, $request->category, $request->page_size, $request->page);

    return response()->json([
      'categories' => $this->newsapi->getCategories(),
      'news' => $news,
      'params' => $request->toArray()
    ]);
  }
}
