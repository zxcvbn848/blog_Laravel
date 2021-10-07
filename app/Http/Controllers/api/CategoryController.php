<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\API\APIController;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use Validator;
use Illuminate\Database\QueryException;

class CategoryController extends APIController
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
        try {
            return $this->sendResponse($this->categoryService->getAll(), 'Category fetched.');
        } catch (QueryException $e) {
            echo $e;
            return $this->sendError('Server Internal Error.', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $input = $request->input();

            $validator = Validator::make($input, [
                'category' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }

            $response = $this->categoryService->create($input);

            return $this->sendResponse($response, 'Category created.', 201);
        } catch (QueryException $e) {
            echo $e;
            return $this->sendError('Server Internal Error.', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $response = $this->categoryService->getOne($id);

            if (is_null($response)) {
                return $this->sendError('Category does not exist.');
            }

            return $this->sendResponse($response, 'Category fetched.');
        } catch (QueryException $e) {
            echo $e;
            return $this->sendError('Server Internal Error.', 500);
        }
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
        try {
            $category = $this->categoryService->getOne($id);

            if (is_null($category)) {
                return $this->sendError('Category does not exist.');
            }

            $response = $this->categoryService->delete($id);

            if (is_null($response)) {
                return $this->sendResponse($response, 'Category deleted.');
            } else {
                return $this->sendError('Delete Category failed.', 400);
            }
        } catch (QueryException $e) {
            echo $e;
            return $this->sendError('Server Internal Error.', 500);
        }
    }
}
