<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Article extends Model
{
    use HasFactory;

    public $with = [
        'comments',
        'user',
        'category'
    ];

    protected $fillable = [
        "title",
        "body",
        "category_id"
        ,
        "user_id"
    ];


    // Scopes

    // search article local scope
    public function scopeSearch(Builder $query, $phrase): void
    {
        $query->where('title', 'like', '%'.$phrase.'%')
        ->orWhere('body', 'like', '%'.$phrase.'%');
    }

    // filter by category local scope
    public function scopeFilterByCategory(Builder $query, $id) : void
    {
        $query->where('category_id', '=', $id);
    }


    // popular articles local scope
    public function scopeGetPopularArticles(Builder $query) : void
    {
        $query->has('comments', '>', 5)->take(5)->withCount('comments')->orderByDesc('comments_count');
    }


    // Model Relationships

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
