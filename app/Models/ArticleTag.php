<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ArticleTag extends Pivot
{
    protected $table = 'article_tag';
    public $incrementing = true;
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'tag_id', 'article_id'
    ];
    use HasFactory;

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
