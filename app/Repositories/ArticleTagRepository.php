<?php

namespace App\Repositories;

use App\Models\ArticleTag;

class ArticleTagRepository
{
    protected $articleTag;

    public function __construct(ArticleTag $articleTag)
    {
        $this->articleTag = $articleTag;
    }

    public function searchTags($id)
    {
        return ArticleTag::where('article_id', $id)->get();
    }

    public function searchTag($article, $tag)
    {
        return ArticleTag::where('article_id', $article['id'])->where('tag_id', $tag['id'])->first();
    }

    public function post($article, $tags)
    {
        if (!$article || !$tags) return;

        $articleTags = [];

        foreach ($tags as $tag) {
            $articleTag = ArticleTag::create([
                'tag_id' => $tag['id'],
                'article_id' => $article['id'],
            ]);
            array_push($articleTags, $articleTag);
        }

        return $articleTags;
    }

    public function patch($article, $tags)
    {
        if (!$article || !$tags) return;

        $articleTags = [];
        $idOfTags = [];

        foreach ($tags as $tag) {
            $selectedTag = $this->searchTag($article, $tag);

            if (!$selectedTag) {
                $selectedTag = ArticleTag::create([
                    'tag_id' => $tag['id'],
                    'article_id' => $article['id'],
                ]);
            }

            array_push($articleTags, $selectedTag);
            array_push($idOfTags, $selectedTag['tag_id']);
        }

        $notIncludedArticleTags = ArticleTag::where('article_id', $article['id'])->whereNotIn('tag_id', $idOfTags)->get();

        foreach ($notIncludedArticleTags as $articleTag) {
            $articleTag->delete();
        }

        return $articleTags;
    }

    public function delete($id)
    {
        $articleTags = $this->searchTags($id);

        foreach ($articleTags as $articleTag) {
            $articleTag->delete();
        }
    }
}
