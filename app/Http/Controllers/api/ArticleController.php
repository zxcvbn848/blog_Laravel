<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Services\ArticleService;
use Validator;
use Illuminate\Support\Facades\Auth;

class ArticleController extends BaseController
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
        return $this->sendResponse($this->articleService->getAll(), 'Article fetched.');
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
            'title' => 'required',
            'article' => 'required',
            'category' => 'required',
            'tags' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $response = $this->articleService->create($input);

        return $this->sendResponse($response, 'Article created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->articleService->getFullOne($id);

        if (is_null($response)) {
            return $this->sendError('Article does not exist.');
        }

        return $this->sendResponse($response, 'Article fetched.');
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
        $input = $request->input();

        $article = $this->articleService->getFullOne($id);

        if (is_null($article)) {
            return $this->sendError('Article does not exist.');
        }

        if ($article['author_id'] != Auth::user()->id) {
            return $this->sendError('You are not the author of the article.');
        }

        $response = $this->articleService->update($id, $input);

        return $this->sendResponse($response, 'Article updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
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
    }
}
