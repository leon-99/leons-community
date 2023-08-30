<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        $categories = Category::all();
        $popularArticles = Article::getPopularArticles()->get();

        return view("articles.index", [
            'articles' => $articles,
            'categories' => $categories,
            'popularArticles' => $popularArticles
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
        if(Gate::denies('article-store', $request->user_id)) {
            abort(403);
        }

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

        return redirect()->route('article.show', $article->id)->with("info", "article updated");
    }


    // article search
    public function search(Request $request)
    {
        $validated = $request->validate([
            'phrase' => 'required|string|max:255'
        ]);

        // using the search local scope in the article model
        $articles = Article::search($validated['phrase'])->latest()->paginate(10);
        $users = User::search($validated['phrase'])->latest()->get();
        $popularArticles = Article::getPopularArticles()->get();
        $count = $articles->count() + $users->count();

        $categories = Category::all();

        return view("articles.index", [
                    "articles" => $articles,
                    'count' => $count,
                    'categories' => $categories,
                    'popularArticles' => $popularArticles,
                    'users' => $users,
                    'title' => "Search results of '".$validated['phrase']."'"
                ]);

            }
    public function filterByCategory(Category $category)
    {

        $articles = Article::filterByCategory($category->id)->latest()->paginate(10);
        $popularArticles = Article::getPopularArticles()->get();

        $categories = Category::all();

        return view("articles.index", [
            "articles" => $articles,
            'count' => $articles->count(),
            'categories' => $categories,
            'popularArticles' => $popularArticles,
            'title' => "Category of '".$category->name."'"
        ]);
    }


    public function delete(Article $article)
    {
        if (Gate::denies('article-delete', $article)) {
            return back()->with('warning', "Article delete failed");
        }
        // delete the article image
        $image = 'public/' . $article->image;
        Storage::delete($image);

        // delete the article from database
        $article->delete();

        // redirect
        if (request()->has('from-profile') == "profile") {
            return redirect("/home")->with("info", "An article deleted");
        }

        return redirect("/")->with("info", "An article deleted");
    }
}
