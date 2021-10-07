<?php

/**
* @OA\Get(
*     path="/api/articles",
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
