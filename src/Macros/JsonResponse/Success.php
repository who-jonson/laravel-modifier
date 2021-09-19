<?php


namespace WhoJonson\LaravelOrganizer\Macros\JsonResponse;


use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

/**
 * Class Success
 * @package WhoJonson\LaravelOrganizer\Macros
 */
class Success
{
    /**
     * @mixin Response
     */
    public function __invoke() : Closure
    {
        /**
         * @param mixed $data
         * @param string|null $message
         * @param array $headers
         *
         * @return JsonResponse
         */
        return function ($data = [], string $message = null, array $headers = []) : JsonResponse
        {
            $response = [
                'data'    => $data,
                'success' => true,
                'message' => $message ?: 'Request processed successfully'
            ];

            return new JsonResponse($response, Response::HTTP_OK, $headers);
        };
    }
}
