<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Database\QueryException;

class TagRepository
{
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function search($tag)
    {
        return Tag::where('tag', $tag)->first();
    }

    public function post($input)
    {
        if (!array_key_exists('tags', $input)) return;
        if (!$input['tags']) return;

        try {
            $tags = [];

            foreach ($input['tags'] as $tag) {
                $selectedTag = $this->search($tag);

                if ($selectedTag) {
                    $addedTag = $selectedTag;
                } else {
                    $addedTag = Tag::create([
                        'tag' => $tag,
                    ]);
                }

                array_push($tags, $addedTag);
            }

            return $tags;
        } catch (QueryException $e) {
            echo $e->getMessage();
            throw $e;
        }
    }
}
