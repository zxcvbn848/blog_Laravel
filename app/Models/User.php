<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable =
        ['username','account','email','password'];
    use HasFactory;

    public function article()
    {
        return $this->hasOne(Article::class);
    }
    use HasFactory;
}
