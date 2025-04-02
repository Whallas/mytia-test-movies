<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(
 *     title="MyTIA Test Movies API",
 *     version="1.0.0",
 *     description="API to manage users, movies, favorites, and more.",
 *     @OA\Contact(
 *         email="support@example.com"
 *     )
 * )
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Dynamic server based on the environment"
 * )
 */
abstract class Controller
{
    use AuthorizesRequests;
}
