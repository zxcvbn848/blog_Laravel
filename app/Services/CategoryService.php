<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function getAll()
    {
        return [
            $this->categoryRepo->getAll(),
            ];
    }

    public function getOne($id)
    {
        return [
            $this->categoryRepo->getOne($id),
            ];

    }

    public function create($input)
    {
        $category = $this->categoryRepo->post($input);

        return $this->categoryRepo->post($input);
    }

    public function delete($id)
    {
        $this->categoryRepo->delete($id);

        return $this->categoryRepo->getOne($id);
    }
}
