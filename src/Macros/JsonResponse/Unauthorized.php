<?php


namespace WhoJonson\LaravelOrganizer\Macros\JsonResponse;


use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

/**
 * Class Unauthorized
 * @package WhoJonson\LaravelOrganizer\Macros
 */
class Unauthorized
{
    /**
     * @mixin Response
     */
    public function __invoke() : Closure
    {
        /**
         *
         * @param string $message
         * @param array $headers
         *
         * @return JsonResponse
         */
        return function (string $message = 'Unauthorized!', array $headers = []) : JsonResponse
        {
            $response = [
                'success' => false,
                'message' => $message
            ];
            return new JsonResponse($response, Response::HTTP_UNAUTHORIZED, $headers);
        };
    }
}
