<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\NewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
  public function index(): object
  {
    $news = News::orderBy('created_at', 'desc')->get();

    return response()->json([
      'news' => [
        'articles' => $news,
        'articlesCount' => count($news)
      ]
    ]);
  }

  public function show(int $id): object
  {
    $article = News::find($id);

    return response()->json([
      'article' => $article,
    ]);
  }

  public function store(NewsRequest $request): object
  {
    $news = new News();
    $news->author = $request->author;
    $news->title = $request->title;
    $news->url = $request->url;
    $news->content = $request->content;
    $news->category_id = $request->category;
    $news->user_id = Auth::id();
    $news->save();

    return response()->json([
      'message' => 'News succesfully published'
    ]);
  }

  public function update(NewsRequest $request, int $id): object
  {
    $news = News::find($id);
    $news->author = $request->author;
    $news->title = $request->title;
    $news->url = $request->url;
    $news->content = $request->content;
    $news->category_id = $request->category;
    $news->save();

    return response()->json([
      'message' => 'News succesfully updated'
    ]);
  }

  public function destroy(int $id): object
  {
    $news = News::find($id);
    $news->delete();

    return response()->json([
      'message' => 'Article deleted succesfully'
    ]);
  }
}
