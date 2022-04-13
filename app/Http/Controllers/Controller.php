<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 *  @OA\OpenApi(
 *      security={
 *          {"passport": {}},
 *          {"bearerAuth": {}},
 *      }
 *  )
 *
 *  @OA\Info(
 *      description="API Document",
 *      version="1.0.0",
 *      title="API",
 *  )
 *
 *  @OA\SecurityScheme(
 *      type="http",
 *      securityScheme="bearerAuth",
 *      scheme="bearer"
 *  )
 *
 *  @OA\Parameter(
 *      name="page",
 *      in="query",
 *      @OA\Schema(
 *          type="integer",
 *          format="int64",
 *      )
 *  )
 *
 *  @OA\Parameter(
 *      name="limit",
 *      in="query",
 *      @OA\Schema(
 *          type="integer",
 *          format="int64",
 *      )
 *  )
 *
 *  @OA\Parameter(
 *      name="order_by",
 *      in="query",
 *      @OA\Schema(
 *          type="string",
 *      )
 *  )
 *
 *  @OA\Parameter(
 *      name="order_type",
 *      in="query",
 *      @OA\Schema(
 *          type="integer",
 *          format="int64",
 *      )
 *  )
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
}
