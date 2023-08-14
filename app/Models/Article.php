<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "body",
        "category_id"
        ,
        "user_id"
    ];

    // search article local scope
    public function scopeSearch(Builder $query, $phrase): void
    {
        $query->where('title', 'like', '%'.$phrase.'%')
        ->orWhere('body', 'like', '%'.$phrase.'%');
    }

    public function scopeFilterByCategory(Builder $query, $id) : void
    {
        $query->where('category_id', '=', $id);
    }

    public function scopeGetPopularArticles(Builder $query) : void
    {
        $query->has('comments', '>', 5)->take(5)->withCount('comments')->orderByDesc('comments_count');
    }


    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }
}
