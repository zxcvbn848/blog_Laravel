<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use App\Repositories\ArticleTagRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\TagRepository;

class ArticleService
{
    protected $articleRepo;
    protected $articleTagRepo;
    protected $categoryRepo;
    protected $tagRepo;

    public function __construct(ArticleRepository $articleRepo, ArticleTagRepository $articleTagRepo, CategoryRepository $categoryRepo, TagRepository $tagRepo)
    {
        $this->articleRepo = $articleRepo;
        $this->articleTagRepo = $articleTagRepo;
        $this->categoryRepo = $categoryRepo;
        $this->tagRepo = $tagRepo;
    }

    public function getAll()
    {
        return $this->articleRepo->getAll();
    }

    public function getFullOne($id)
    {
        return $this->articleRepo->getFullOne($id);
    }

    public function create($input)
    {
        $category = $this->categoryRepo->post($input);
        $article = $this->articleRepo->post($input, $category);
        $tags = $this->tagRepo->post($input);
        $this->articleTagRepo->post($article, $tags);

        return $this->getFullOne($article['id']);
    }

    public function update($id, $input)
    {
        $article = $this->articleRepo->getOne($id);

        $category = $this->categoryRepo->patch($input, $article);

        $article = $this->articleRepo->patch($article, $input, $category);

        $tags = $this->tagRepo->post($input);
        $this->articleTagRepo->patch($article, $tags);

        return $this->getFullOne($article['id']);
    }

    public function delete($id)
    {
        $article = $this->articleRepo->getOne($id);

        $this->articleRepo->delete($id);
        $this->articleTagRepo->delete($id);

        $article = $this->articleRepo->getOne($id);
        $articleTag = $this->articleTagRepo->searchTags($id);

        if (!$article && !count($articleTag)) {
            return NULL;
        } else {
            return $this->articleRepo->getOne($id);
        }
    }
}
