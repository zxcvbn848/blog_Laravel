<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Database\QueryException;

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
        try {
            $category = $this->categoryRepo->post($input);

            return $this->categoryRepo->post($input);
        } catch (QueryException $e) {
            echo $e->getMessage();
            return 'Server Internal error';
        }
    }

    public function delete($id)
    {
        try {
            $this->categoryRepo->delete($id);

            return $this->categoryRepo->getOne($id);
        } catch (QueryException $e) {
            echo $e->getMessage();
            return 'Server Internal error';
        }
    }
}
