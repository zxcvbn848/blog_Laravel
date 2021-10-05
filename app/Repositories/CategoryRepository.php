<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\QueryException;

class CategoryRepository
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAll()
    {
        return Category::orderBy('id')->get();
    }

    public function getOne($id)
    {
        return Category::find($id);
    }

    public function search($input)
    {
        return Category::where('category', $input['category'])->first();
    }

    public function post($input)
    {
        if (!$input['category']) return;

        $selectedCategory = $this->search($input);

        try {
            if ($selectedCategory) {
                $category = $selectedCategory;
            } else {
                $category = Category::create([
                    'category' => $input['category'],
                ]);
            }

            return $category;
        } catch (QueryException $e) {
            echo $e->getMessage();
            throw $e;
        }
    }

    public function patch($input, $article)
    {
        if (!array_key_exists('category', $input)) {
            return Category::findOrFail($article['category_id']);
        }
        if (!$input['category']) {
            return Category::findOrFail($article['category_id']);
        }

        $selectedCategory = $this->search($input);

        try {
            if ($selectedCategory) {
                $category = $selectedCategory;
            } else {
                $category = Category::create([
                    'category' => $input['category'],
                ]);
            }

            return $category;
        } catch (QueryException $e) {
            echo $e->getMessage();
            throw $e;
        }
    }

    public function delete($id)
    {
        try {
            Category::find($id)->delete();
        } catch (QueryException $e) {
            echo $e->getMessage();
            throw $e;
        }
    }
}
