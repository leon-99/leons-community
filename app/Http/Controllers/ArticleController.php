<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(10);

        return view("articles.index", [
            "articles" => $articles
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


    public function store(StoreArticleRequest $request)
    {
        $article = new Article;
        $article->title = $request->title;
        $article->body = $request->body;
        $article->category_id = $request->category_id;
        $article->user_id = auth()->user()->id;
        if ($request->hasFile('image')) {

            $imageName = 'article-images/' . auth()->user()->id . '/' . time() . '.' . $request->image->extension();

            $request->image->storeAs('public', $imageName);
            $article->image = $imageName;
        }
        $article->save();

        return redirect()->route('index');
    }


    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->title = $request->title;
        $article->body = $request->body;
        $article->category_id = $request->category_id;
        if ($request->hasFile('image')) {
            // delete the old image
            $oldImage = 'public/' . $article->image;
            Storage::delete($oldImage);

            // update the article
            $imageName = 'article-images/' . auth()->user()->id . '/' . time() . '.' . $request->image->extension();
            $request->image->storeAs('public', $imageName);
            $article->image = $imageName;
        }
        $article->save();

        return redirect()->route('article.show', $article->id)->with("article-updated", "article updated");
    }


    // article search
    public function search(Request $request)
    {
        $validated = $request->validate([
            'phrase' => 'required|string|max:255'
        ]);

        // using the local scope in the article model
        $articles = Article::search($validated['phrase'])->paginate(10);

        return view("articles.index", [
            "articles" => $articles
        ]);
    }


    public function delete(Article $article)
    {
        if (Gate::denies('article-delete', $article)) {
            return back()->with('article-delete-error', "Article delete failed");
        }
        // delete the article image
        $image = 'public/' . $article->image;
        Storage::delete($image);

        // delete the article from database
        $article->delete();

        // redirect
        if (request()->has('from-profile') == "profile") {
            return redirect("/home")->with("article-delete-success", "An article deleted");
        }

        return redirect("/")->with("article-delete-success", "An article deleted");
    }
}
