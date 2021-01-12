<?php

/**
 * Laravel Organizer Service Provider
 *
 * @author    Jonson B. <www.jbc.bd@gmail.com>
 * @copyright 2021 Jonson B. (https://who-jonson.github.io)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/who-jonson/laravel-organizer
 */

namespace WhoJonson\LaravelOrganizer;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use WhoJonson\LaravelOrganizer\Console\Commands\ModelMake;
use WhoJonson\LaravelOrganizer\Console\Commands\RepositoryClassMake;
use WhoJonson\LaravelOrganizer\Console\Commands\RepositoryInterfaceMake;
use WhoJonson\LaravelOrganizer\Console\Commands\RepositoryMake;

/**
 * Class LaravelOrganizerServiceProvider
 * @package WhoJonson\LaravelOrganizer
 */
class LaravelOrganizerServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() : void
    {
        $configPath = __DIR__ . '/../config/laravel-organizer.php';

        if (function_exists('config_path')) {
            $publishPath = config_path('laravel-organizer.php');
        } else {
            $publishPath = base_path('config/laravel-organizer.php');
        }
        $this->publishes([$configPath => $publishPath], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() : void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravel-organizer.php', 'laravel-organizer'
        );

        $this->bindServices();

        $this->commands([
            'command.make.model',
            'command.make.repository',
            'command.make.repository-class',
            'command.make.repository-interface'
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() : array
    {
        return [
            'command.make.model',
            'command.make.repository'
        ];
    }

    /**
     * Bind service classes provided by the provider.
     *
     * @return void
     */
    private function bindServices() : void
    {
        $this->app->singleton(
            'command.make.model',
            function ($app) {
                return new ModelMake($app['files'], $app['config']);
            }
        );

        $this->app->singleton(
            'command.make.repository',
            function ($app) {
                return new RepositoryMake($app['files'], $app['config']);
            }
        );

        $this->app->singleton(
            'command.make.repository-interface',
            function ($app) {
                return new RepositoryClassMake($app['files'], $app['config']);
            }
        );

        $this->app->singleton(
            'command.make.repository-class',
            function ($app) {
                return new RepositoryInterfaceMake($app['files'], $app['config']);
            }
        );
    }
}
