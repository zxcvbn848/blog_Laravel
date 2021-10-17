<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'tag'
    ];
    use HasFactory;

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'articles_tags', 'tag_id', 'article_id')->using(ArticleTag::class)->as('articles_tags');
    }
}
