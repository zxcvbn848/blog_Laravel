<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ArticleTag extends Pivot
{
    protected $table = 'articles_tags';
    protected $primaryKey = 'id';
    public $incrementing = true;
    // public $timestamps = false;
    protected $fillable = [
        'tag_id', 'article_id'
    ];
    use HasFactory;

    public function tag()
    {
        return $this->belongsTo(Tags::class);
    }

    public function article()
    {
        return $this->belongsTo(Articles::class);
    }
}
