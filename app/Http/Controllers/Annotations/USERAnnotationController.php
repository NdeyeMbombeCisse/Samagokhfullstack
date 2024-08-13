<?php

namespace App\Http\Controllers\Annotations ;

/**
 * @OA\Security(
 *     security={
 *         "BearerAuth": {}
 *     }),

 * @OA\SecurityScheme(
 *     securityScheme="BearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"),

 * @OA\Info(
 *     title="Your API Title",
 *     description="Your API Description",
 *     version="1.0.0"),

 * @OA\Consumes({
 *     "multipart/form-data"
 * }),

 *

 * @OA\PUT(
 *     path="/api/update-profile/8",
 *     summary="modification",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="prenom", type="string"),
 *                     @OA\Property(property="nom", type="string"),
 *                     @OA\Property(property="date_naissance", type="string"),
 *                     @OA\Property(property="adresse", type="string"),
 *                     @OA\Property(property="lieu_naissance", type="string"),
 *                     @OA\Property(property="fonction", type="string"),
 *                     @OA\Property(property="genre", type="string"),
 *                     @OA\Property(property="telephone", type="string"),
 *                     @OA\Property(property="situation_matrimoniale", type="string"),
 *                     @OA\Property(property="email", type="string"),
 *                     @OA\Property(property="commune_id", type="integer"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"USER"},
*),


 * @OA\DELETE(
 *     path="/api/delete-account/3",
 *     summary="suppression",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="204", description="Deleted successfully"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 * @OA\Response(response="404", description="Not Found"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="commune_id", type="integer"),
 *                     @OA\Property(property="prenom", type="string"),
 *                     @OA\Property(property="nom", type="string"),
 *                     @OA\Property(property="date_naissance", type="string"),
 *                     @OA\Property(property="adresse", type="string"),
 *                     @OA\Property(property="lieu_naissance", type="string"),
 *                     @OA\Property(property="fonction", type="string"),
 *                     @OA\Property(property="genre", type="string"),
 *                     @OA\Property(property="telephone", type="string"),
 *                     @OA\Property(property="situation_matrimoniale", type="string"),
 *                     @OA\Property(property="date_integration", type="string"),
 *                     @OA\Property(property="date_sortie", type="string"),
 *                     @OA\Property(property="photo", type="string", format="binary"),
 *                     @OA\Property(property="email", type="string"),
 *                     @OA\Property(property="password", type="string"),
 *                     @OA\Property(property="password_confirmation", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"USER"},
*),


 * @OA\POST(
 *     path="/api/users",
 *     summary="Ajout",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="commune_id", type="integer"),
 *                     @OA\Property(property="prenom", type="string"),
 *                     @OA\Property(property="nom", type="string"),
 *                     @OA\Property(property="date_naissance", type="string"),
 *                     @OA\Property(property="adresse", type="string"),
 *                     @OA\Property(property="lieu_naissance", type="string"),
 *                     @OA\Property(property="fonction", type="string"),
 *                     @OA\Property(property="genre", type="string"),
 *                     @OA\Property(property="telephone", type="string"),
 *                     @OA\Property(property="situation_matrimoniale", type="string"),
 *                     @OA\Property(property="email", type="string"),
 *                     @OA\Property(property="password", type="string"),
 *                     @OA\Property(property="password_confirmation", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"USER"},
*),


 * @OA\GET(
 *     path="/api/users",
 *     summary="Afficher",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="commune_id", type="integer"),
 *                     @OA\Property(property="prenom", type="string"),
 *                     @OA\Property(property="nom", type="string"),
 *                     @OA\Property(property="date_naissance", type="string"),
 *                     @OA\Property(property="adresse", type="string"),
 *                     @OA\Property(property="lieu_naissance", type="string"),
 *                     @OA\Property(property="fonction", type="string"),
 *                     @OA\Property(property="genre", type="string"),
 *                     @OA\Property(property="telephone", type="string"),
 *                     @OA\Property(property="situation_matrimoniale", type="string"),
 *                     @OA\Property(property="date_integration", type="string"),
 *                     @OA\Property(property="date_sortie", type="string"),
 *                     @OA\Property(property="photo", type="string", format="binary"),
 *                     @OA\Property(property="email", type="string"),
 *                     @OA\Property(property="password", type="string"),
 *                     @OA\Property(property="password_confirmation", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"USER"},
*),


*/

 class USERAnnotationController {}
