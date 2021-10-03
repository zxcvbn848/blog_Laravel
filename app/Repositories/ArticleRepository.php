<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function getArticles()
    {
        return Article::with([
            'author' => function($query)
            {
                return $query->select('id', 'username');
            },
            'category' => function($query)
            {
                return $query->select('id', 'category');
            },
            'tags'
        ])->get();
    }

    public function getArticle($id) {
        return Article::with([
            'author' => function($query)
            {
                return $query->select('id', 'username');
            },
            'category' => function($query)
            {
                return $query->select('id', 'category');
            },
            'tags'
        ])->find($id);
    }
}
