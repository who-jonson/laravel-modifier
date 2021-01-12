<?php


namespace WhoJonson\LaravelOrganizer\Macros\JsonResponse;


use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Class CantProcess
 *
 * @package WhoJonson\LaravelOrganizer\Macros
 */
class CantProcess
{
    /**
     * @mixin Response
     */
    public function __invoke() : Closure
    {
        /**
         * @param Throwable|null $error
         * @param string|null $message
         * @param array $headers
         *
         * @return JsonResponse
         */
        return function (Throwable $error = null, string $message = null, array $headers = []) : JsonResponse
        {
            if (!$message){
                $message = $error && config('app.debug')
                    ? $error->getMessage().'. Location : ' . $error->getFile() .' at line : ' . $error->getLine()
                    : 'Cannot process request!';
            }
            $response = [
                'success' => false,
                'message' =>  $message
            ];

            return new JsonResponse($response, Response::HTTP_BAD_REQUEST, $headers);
        };
    }
}
