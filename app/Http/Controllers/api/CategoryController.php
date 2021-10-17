<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\API\APIController;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Requests\Category\AddCategoryFormRequest;

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
    /**
    * @OA\Get(
    *     path="/api/category",
    *     tags={"Category"},
    *     summary="Get list of categories",
    *     description="Get list of categories",
    *     @OA\Response(
    *         response="200",
    *         description="Categories fetched."
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Server Internal Error."
    *     ),
    * )
    * Returns list of categories
    */
    public function index()
    {
        try {
            return $this->sendResponse($this->categoryService->getAll(), 'Category fetched.');
        } catch (\Exception $e) {
            $exMessage = $e->getMessage();
            return $this->sendError('catch exception: '.$exMessage, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
    * @OA\Post(
    *     path="/api/category",
    *     operationId="categoryStore",
    *     tags={"Category"},
    *     summary="Create Category",
    *     description="Create Category",
    *     security={
    *         {
    *              "Authorization": {}
    *         }
    *     },
    *     @OA\Parameter(
    *         name="category",
    *         description="content of category",
    *         required=true,
    *         in="query",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Category created."
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="A kind of {request errors from Validator}."
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Server Internal Error."
    *     ),
    * )
    * Create a category
    */
    public function store(AddCategoryFormRequest $request)
    {
        $input = $request->input();

        try {

            $response = $this->categoryService->create($input);

            return $this->sendResponse($response, 'Category created.', 201);
        } catch (\Exception $e) {
            $exMessage = $e->getMessage();
            return $this->sendError('catch exception: '.$exMessage, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
    * @OA\Get(
    *     path="/api/category/{id}",
    *     operationId="categoryShow",
    *     tags={"Category"},
    *     summary="Get an category",
    *     description="Get an category",
    *     @OA\Parameter(
    *         name="id",
    *         description="Category id",
    *         required=true,
    *         in="path",
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Category fetched."
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Category does not exist."
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Server Internal Error."
    *     ),
    * )
    * Show a category
    */
    public function show($id)
    {
        try {
            $response = $this->categoryService->getOne($id);

            if (is_null($response)) {
                return $this->sendError('Category does not exist.');
            }

            return $this->sendResponse($response, 'Category fetched.');
        } catch (\Exception $e) {
            $exMessage = $e->getMessage();
            return $this->sendError('catch exception: '.$exMessage, 500);
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
    /**
    * @OA\Delete(
    *     path="/api/category/{id}",
    *     operationId="categoryDeStroy",
    *     tags={"Category"},
    *     summary="Delete Category",
    *     description="Delete Category",
    *     security={
    *         {
    *              "Authorization": {}
    *         }
    *     },
    *     @OA\Parameter(
    *         name="id",
    *         description="Category id",
    *         required=true,
    *         in="path",
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Category deleted."
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Delete Category failed."
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Category does not exist."
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Server Internal Error."
    *     ),
    * )
    * Delete a category
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
        } catch (\Exception $e) {
            $exMessage = $e->getMessage();
            return $this->sendError('catch exception: '.$exMessage, 500);
        }
    }
}
