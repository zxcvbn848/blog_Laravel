<?php

namespace App\Services;

use App\Repositories\ArticleRepository;

class ArticleService
{
    protected $articleRepo;

    public function __construct(ArticleRepository $articleRepo)
    {
        $this->articleRepo = $articleRepo;
    }

    public function getBlog()
    {
        return [
            'article' => $this->articleRepo->getArticles()
        ];
    }

    public function getArticle($id)
    {
        return $this->articleRepo->getArticle($id);
    }
}
