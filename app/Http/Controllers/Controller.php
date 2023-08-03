<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Admin Documentation",
 *      description="Admin open API description",
 *      @OA\Contact(
 *          email="hossamibenbaida@gmail.com"
 *      ),
 *      @OA\Server(
 *          url=L5_SWAGGER_CONST_HOST ,
 *         description="Admin API Server",
 *      )
 * )
 * 
 * @OA\SecurityScheme(
 *     type="http",
 *     securityScheme="bearerAuth",
 *     scheme="bearer",
 *     description="Bearer token authentication"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


}
