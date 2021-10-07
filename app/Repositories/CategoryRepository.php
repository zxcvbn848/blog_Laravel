<?php

namespace App\Repositories;

use App\Models\Category;

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

        if ($selectedCategory) {
            $category = $selectedCategory;
        } else {
            $category = Category::create([
                'category' => $input['category'],
            ]);
        }

        return $category;
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

        if ($selectedCategory) {
            $category = $selectedCategory;
        } else {
            $category = Category::create([
                'category' => $input['category'],
            ]);
        }

        return $category;
    }

    public function delete($id)
    {
        Category::find($id)->delete();
    }
}
