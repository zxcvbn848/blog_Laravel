<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class ArticleRepository
{
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function getAll()
    {
        return Article::with([
            'author' => function($query)
            {
                return $query->select('id', 'name');
            },
            'category' => function($query)
            {
                return $query->select('id', 'category');
            },
            'tags',
        ])->get();
    }

    public function getFullOne($id)
    {
        return Article::with([
            'author' => function($query)
            {
                return $query->select('id', 'name');
            },
            'category' => function($query)
            {
                return $query->select('id', 'category');
            },
            'tags',
        ])->find($id);
    }

    public function getOne($id)
    {
        return Article::find($id);
    }

    public function post($input, $category)
    {
        if (!$input['title'] || !$input['article'] || !$category) return;

        try {
            $article = Article::create([
                'title' => $input['title'],
                'author_id' => Auth::user()->id,
                'category_id' => $category['id'],
                'article' => $input['article'],
            ]);

            return $article;
        } catch (QueryException $e) {
            echo $e->getMessage();
            throw $e;
        }
    }

    public function patch($article, $input, $category)
    {
        if (!array_key_exists('title', $input) && !array_key_exists('article', $input)) {
            return $article;
        }
        if (!$input['title'] && !$input['article']) {
            return $article;
        }

        try {
            if ($category) {
                $article->category_id = $category['id'];
                $article->save();
            }

            if (array_key_exists('title', $input) && $input['title']) {
                $article->title = $input['title'];
                $article->save();
            }

            if (array_key_exists('article', $input) && $input['article']) {
                $article->article = $input['article'];
                $article->save();
            }

            return $article;
        } catch (QueryException $e) {
            echo $e->getMessage();
            throw $e;
        }
    }

    public function delete($id)
    {
        try {
            Article::find($id)->delete();
        } catch (QueryException $e) {
            echo $e->getMessage();
            throw $e;
        }
    }
}
