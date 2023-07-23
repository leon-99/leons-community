<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $data = Article::latest()->paginate(5);

        return view("articles.index", [
            "articles" => $data
        ]);
    }

    public function show(Article $article)
    {
        $categories = Category::all();
        return view('articles.detail', [
            'article' => $article,
            "categories" => $categories
        ]);
    }


    public function create()
    {
        $categories = Category::all();
        return view("articles.add", [
            "categories" => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            "title" => "required",
            "body" => "required",
            "category_id" => "required",
            "image" => "mimes:jpeg,png,jpg,gif|max:3072"
        ]);

        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->user_id = auth()->user()->id;
        if (request()->hasFile('image')) {
            $article->image = request()->file('image')->store('images', 'public');
        }
        $article->save();

        return redirect()->route('index');
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('articles.article-edit', [
            "article" => $article,
            "categories" => $categories
        ]);
    }

    public function update(Article $article)
    {
        if (Gate::denies('article-update', $article)) {
            return back()->with('article-edit-error', "Article delete failed");
        }

        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        if (request()->hasFile('image')) {
            $article->image = request()->file('image')->store('images', 'public');
        }
        $article->save();

        return redirect("/articles/detail/$article->id")->with("article-updated", "article updated");
    }

    public function delete(Article $article)
    {
        if (Gate::denies('article-delete', $article)) {
            return back()->with('article-delete-error', "Article delete failed");
        }


        // Storage::delete($article->image);
        // Storage::disk('local')->delete($article->image);
        $article->delete();
        if (request()->from == "profile") {
            return redirect("/home")->with("article-delete-success", "An article deleted");
        } else {
            return redirect("/")->with("article-delete-success", "An article deleted");
        }
    }
}
