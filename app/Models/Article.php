<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'article', 'author_id', 'title', 'category_id'
    ];
    use HasFactory;

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'articles_tags', 'article_id', 'tag_id')->using(ArticleTag::class)->as('articles_tags');
    }
}
