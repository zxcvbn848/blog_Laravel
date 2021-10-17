<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\API\APIController;
use App\Services\ArticleService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Article\AddArticleFormRequest;
use App\Http\Requests\Article\EditArticleFormRequest;

class ArticleController extends APIController
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
    * @OA\Get(
    *     path="/api/article",
    *     tags={"Article"},
    *     summary="Get list of articles",
    *     description="Get list of articles",
    *     @OA\Response(
    *         response="200",
    *         description="Articles fetched."
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Server Internal Error."
    *     ),
    * )
    * Returns list of articles
    */
    public function index()
    {
        try {
            return $this->sendResponse($this->articleService->getAll(), 'Article fetched.');
        } catch (\Exception $e) {
            $exMessage = $e->getMessage();
            return $this->sendError('Catch Exception: ', $exMessage, 500);
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
    *     path="/api/article",
    *     operationId="articleStore",
    *     tags={"Article"},
    *     summary="Create Article",
    *     description="Create Article",
    *     security={
    *         {
    *              "Authorization": {}
    *         }
    *     },
    *     @OA\Parameter(
    *         name="title",
    *         description="title of article",
    *         required=true,
    *         in="query",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="article",
    *         description="content of article",
    *         required=true,
    *         in="query",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="category",
    *         description="category of article",
    *         required=true,
    *         in="query",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="tags",
    *         description="tags of article",
    *         required=true,
    *         in="query",
    *         @OA\Schema(
    *             type="array",
    *             @OA\Items(type="string"),
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Article created."
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
    * Create an article
    */
    public function store(AddArticleFormRequest $request)
    {
        $input = $request->input();

        try {
            $response = $this->articleService->create($input);

            return $this->sendResponse($response, 'Article created.', 201);
        } catch (\Exception $e) {
            $exMessage = $e->getMessage();
            return $this->sendError('Catch Exception: ', $exMessage, 500);
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
    *     path="/api/article/{id}",
    *     operationId="articleShow",
    *     tags={"Article"},
    *     summary="Get an article",
    *     description="Get an article",
    *     @OA\Parameter(
    *         name="id",
    *         description="Article id",
    *         required=true,
    *         in="path",
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Article fetched."
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Article does not exist."
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Server Internal Error."
    *     ),
    * )
    * Show an article
    */
    public function show($id)
    {
        try {
            $response = $this->articleService->getFullOne($id);

            if (is_null($response)) {
                return $this->sendError('Article does not exist.');
            }

            return $this->sendResponse($response, 'Article fetched.');
        } catch (\Exception $e) {
            $exMessage = $e->getMessage();
            return $this->sendError('Catch Exception: ', $exMessage, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
    * @OA\Patch(
    *     path="/api/article/{id}",
    *     operationId="articleUpdate",
    *     tags={"Article"},
    *     summary="Update Article",
    *     description="Update Article",
    *     security={
    *         {
    *              "Authorization": {}
    *         }
    *     },
    *     @OA\Parameter(
    *         name="id",
    *         description="Article id",
    *         required=true,
    *         in="path",
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="title",
    *         description="title of article",
    *         in="query",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="article",
    *         description="content of article",
    *         in="query",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="category",
    *         description="category of article",
    *         in="query",
    *         @OA\Schema(
    *             type="string"
    *         )
    *     ),
    *     @OA\Parameter(
    *         name="tags",
    *         description="tags of article",
    *         in="query",
    *         @OA\Schema(
    *             type="array",
    *             @OA\Items(type="string"),
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Article updated."
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="You are not the author of the article."
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Article does not exist."
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Server Internal Error."
    *     ),
    * )
    * Update an article
    */
    public function update(EditArticleFormRequest $request, $id)
    {
        try {
            $input = $request->input();

            $article = $this->articleService->getFullOne($id);

            if (is_null($article)) {
                return $this->sendError('Article does not exist.');
            }

            if ($article['author_id'] != Auth::user()->id) {
                return $this->sendError('You are not the author of the article.', 401);
            }

            $response = $this->articleService->update($id, $input);

            return $this->sendResponse($response, 'Article updated.', 200);
        } catch (\Exception $e) {
            $exMessage = $e->getMessage();
            return $this->sendError('Catch Exception: ', $exMessage, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
    * @OA\Delete(
    *     path="/api/article/{id}",
    *     operationId="articleDeStroy",
    *     tags={"Article"},
    *     summary="Delete Article",
    *     description="Delete Article",
    *     security={
    *         {
    *              "Authorization": {}
    *         }
    *     },
    *     @OA\Parameter(
    *         name="id",
    *         description="Article id",
    *         required=true,
    *         in="path",
    *         @OA\Schema(
    *             type="integer"
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Article deleted."
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="You are not the author of the article."
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Article does not exist."
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Server Internal Error."
    *     ),
    * )
    * Delete an article
    */
    public function destroy($id)
    {
        try {
            $article = $this->articleService->getFullOne($id);

            if (is_null($article)) {
                return $this->sendError('Article does not exist.');
            }

            if ($article['author_id'] != Auth::user()->id) {
                return $this->sendError('You are not the author of the article.');
            }

            $response = $this->articleService->delete($id);

            if (is_null($response)) {
                return $this->sendResponse($response, 'Article deleted.');
            } else {
                return $this->sendError('Delete Article failed.');
            }
        } catch (\Exception $e) {
            $exMessage = $e->getMessage();
            return $this->sendError('Catch Exception: ', $exMessage, 500);
        }
    }
}
