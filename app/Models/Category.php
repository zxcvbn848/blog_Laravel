<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $fillable = [
        'category'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'category' => 'uncategorized',
    ];

    use HasFactory;

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
