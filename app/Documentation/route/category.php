<?php

/**
* @OA\Get(
*     path="/api/categories",
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
