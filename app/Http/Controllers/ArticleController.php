<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }

    public function index()
    {

        $data = Article::latest()->paginate(5);

        return view("articles.index", [
            "articles" => $data
        ]);
    }

    public function detail($id)
    {
        $posts = Article::find($id);

        // $posts = Article::with(['comments' => function ($query) {
        //     $query->latest();
        // }])->get();

        return view('articles.detail', [
            'article' => $posts
            ]);
    }


    public function add()
    {
        $categories = Category::all();
        return view("articles.add", [
            "categories" => $categories
        ]);
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            "title" => "required",
            "body" => "required",
            "category_id" => "required",
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;
        $article->save();

        return redirect("/articles");
    }
    public function delete($id)
    {
        $article = Article::find($id);
        if(Gate::denies('post-delete', $article)) {
            return back()->with('article-delete-error', "Article delete failed");
        }

        $article->delete();
        if(request()->from == "profile") {
            return redirect("/home")->with("article-delete-success", "An article deleted");
        } else {
            return redirect("/")->with("article-delete-success", "An article deleted");
        }
    }

    public function edit($id)
    {
        $article = Article::find($id);
        return view('articles.article-edit', ["article" => $article]);
    }

    public function update($id)
    {
        $article = Article::find($id);
        $article->title = request()->title;
        $article->body = request()->body;
        $article->save();


        if(request()->from == "profile") {
            return redirect("/home")->with("article-updated", "article updated");
        }
        return redirect("/articles/detail/$article->id")->with("article-updated", "article updated");
    }
}
