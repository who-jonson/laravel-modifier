<?php

/**
 * Laravel Organizer Response Helper Functions
 *
 * @author    Jonson B. <www.jbc.bd@gmail.com>
 * @copyright 2021 Jonson B. (https://who-jonson.github.io)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/who-jonson/laravel-organizer
 */

/**
 * ====================================================================================
 *                          Json (API) Response Helpers
 * ====================================================================================
 */

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

if(!function_exists('jsonSuccess')) {
    /**
     * @param mixed $data
     * @param string|null $message
     * @param array $headers
     *
     * @return JsonResponse
     */
    function jsonSuccess($data = [], string $message = null, array $headers = []): JsonResponse
    {
        return Response::jsonSuccess($data, $message, $headers);
    }
}

if(!function_exists('jsonCreated')) {
    /**
     * @param mixed $data
     * @param string|null $message
     * @param array $headers
     *
     * @return JsonResponse
     */
    function jsonCreated($data = [], string $message = null, array $headers = []): JsonResponse
    {
        return Response::jsonCreated($data, $message, $headers);
    }
}

if(!function_exists('jsonForbidden')) {
    /**
     *
     * @param string $message
     * @param array $headers
     *
     * @return JsonResponse
     */
    function jsonForbidden(string $message = 'Forbidden!', array $headers = []): JsonResponse
    {
        return Response::jsonForbidden($message, $headers);
    }
}

if(!function_exists('jsonUnauthorized')) {
    /**
     * @param string $message
     * @param array $headers
     *
     * @return JsonResponse
     */
    function jsonUnauthorized(string $message = 'Unauthorized!', array $headers = []): JsonResponse
    {
        return Response::jsonUnauthorized($message, $headers);
    }
}

if(!function_exists('jsonCantProcess')) {
    /**
     * @param Throwable|null $error
     * @param string|null $message
     * @param array $headers
     *
     * @return JsonResponse
     */
    function jsonCantProcess(Throwable $error = null, string $message = null, array $headers = []): JsonResponse
    {
        return Response::jsonCantProcess($error, $message, $headers);
    }
}
