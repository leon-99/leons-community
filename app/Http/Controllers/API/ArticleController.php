<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Gate;
Use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        return ArticleResource::collection(Article::latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(StoreArticleRequest $request)
    {
        if(Gate::denies('article-store', $request->user_id)) {
            return response([
                'message' => 'Unauthorized'
            ]);
        }


        $article = new Article;
        $article->title = $request->title;
        $article->body = $request->body;
        $article->category_id = $request->category_id;
        $article->user_id = $request->user_id;
        $article->save();
        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \App\Http\Resources\ArticleResource;
     */
    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \App\Http\Resources\ArticleResource;
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->title = $request->title;
        $article->body = $request->body;
        $article->category_id = $request->category_id;
        $article->save();
        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     *
     */
    public function destroy(Article $article)
    {
        if(Gate::denies('article-delete', $article)) {
            return response([
                'message' => 'Unauthorized'
            ]);
        }

        return $article->delete();
    }

    public function search($title)
    {
        return ArticleResource::collection(Article::where('title', 'like', '%'.$title.'%')->paginate(10));
    }
}
