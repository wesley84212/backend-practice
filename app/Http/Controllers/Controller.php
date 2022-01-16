<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
* @OA\Info(
*      version="1.0.0",
*      title="Currency Test Api",
*      description="Currency Test Api Swagger Document",
*      @OA\Contact(
*          email="wesley84212@gmail.com"
*      ),
*     @OA\License(
*         name="Apache 2.0",
*         url="http://www.apache.org/licenses/LICENSE-2.0.html"
*     )
* )
*/
/**
* @OA\server(
*      url = "http://localhost",
*      description="Localhost"
* )
* @OA\server(
*       url = "http://mybackend-test.herokuapp.com/" ,
*       description="Server"
*)
*/

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
