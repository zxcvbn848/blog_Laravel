<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use Validator;

class CategoryController extends BaseController
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse($this->categoryService->getAll(), 'Article fetched.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $response = $this->categoryService->create($input);

        return $this->sendResponse($response, 'Category created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->categoryService->getOne($id);

        if (is_null($response)) {
            return $this->sendError('Category does not exist.');
        }

        return $this->sendResponse($response, 'Category fetched.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->categoryService->getOne($id);

        if (is_null($category)) {
            return $this->sendError('Category does not exist.');
        }

        $response = $this->categoryService->delete($id);

        if (is_null($response)) {
            return $this->sendResponse($response, 'Category deleted.');
        } else {
            return $this->sendError('Delete Category failed.');
        }
    }
}
