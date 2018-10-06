<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;

/**
 * @SWG\Swagger(
 *   basePath="/CaristoCratApp/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    /**
     * @param $result
     * @param $message
     * @return mixed
     */
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    /**
     * @param $error
     * @param int $code
     * @return mixed
     */
    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    /**
     * @param $error
     * @param int $code
     * @param array $data
     * @return mixed
     */
    public function sendErrorWithData($error, $code = 404, $data = [])
    {
        if (empty($data)) {
            $data = ['errors' => ["error" => [$error]]];
        }
        return Response::json(ResponseUtil::makeError($error, $data), $code);
    }
}
