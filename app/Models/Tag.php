<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'tag'
    ];
    use HasFactory;

    public function articles()
    {
        return $this->belongsToMany(Article::class)->using(ArticleTag::class);
    }
}
