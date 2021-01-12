<?php

/**
 * Laravel Organizer Macro Service Provider
 *
 * @author    Jonson B. <www.jbc.bd@gmail.com>
 * @copyright 2021 Jonson B. (https://who-jonson.github.io)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/who-jonson/laravel-organizer
 */

namespace WhoJonson\LaravelOrganizer;


use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class LaravelOrganizerMacroServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Collection::make($this->jsonResponseMacros())
            ->reject(function ($class, $macro) {
                return Response::hasMacro($macro);
            })
            ->each(function ($class, $macro) {
                Response::macro($macro, app($class)());
            });
    }

    /**
     * @return array|string[]
     */
    private function jsonResponseMacros() : array
    {
        return [
            'jsonCantProcess'       => \WhoJonson\LaravelOrganizer\Macros\JsonResponse\CantProcess::class,
            'jsonCreated'           => \WhoJonson\LaravelOrganizer\Macros\JsonResponse\Created::class,
            'jsonForbidden'         => \WhoJonson\LaravelOrganizer\Macros\JsonResponse\Forbidden::class,
            'jsonSuccess'           => \WhoJonson\LaravelOrganizer\Macros\JsonResponse\Success::class,
            'jsonUnauthorized'      => \WhoJonson\LaravelOrganizer\Macros\JsonResponse\Unauthorized::class,
        ];
    }
}
