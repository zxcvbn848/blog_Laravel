<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\API\APIController;
use Illuminate\Http\Request;
use App\Services\ArticleService;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

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

    public function index()
    {
        try {
            return $this->sendResponse($this->articleService->getAll(), 'Article fetched.');
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
                'title' => 'required',
                'article' => 'required',
                'category' => 'required',
                'tags' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors(), 400);
            }

            $response = $this->articleService->create($input);

            return $this->sendResponse($response, 'Article created.', 201);
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
            $response = $this->articleService->getFullOne($id);

            if (is_null($response)) {
                return $this->sendError('Article does not exist.');
            }

            return $this->sendResponse($response, 'Article fetched.');
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
        } catch (QueryException $e) {
            echo $e;
            return $this->sendError('Server Internal Error.', 500);
        }
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
            $article = $this->articleService->getFullOne($id);

            if (is_null($article)) {
                return $this->sendError('Article does not exist.');
            }

            if ($article['author_id'] != Auth::user()->id) {
                return $this->sendError('You are not the author of the article.');
            }

            $response = $this->articleService->delete($id);

            if (is_null($response)) {
                return $this->sendResponse($response, 'Article deleted.', 204);
            } else {
                return $this->sendError('Delete Article failed.');
            }
        } catch (QueryException $e) {
            echo $e;
            return $this->sendError('Server Internal Error.', 500);
        }
    }
}
