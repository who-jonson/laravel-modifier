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

use Illuminate\Container\Container;
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

        $this->app->alias('organizer', Organizer::class);

        $commands = [
            'command.make.repository',
            'command.make.repository-class',
            'command.make.repository-interface'
        ];

        if (!$this->isVersion9()) {
            array_unshift($commands, 'command.make.model');
        }
        
        $this->commands($commands);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() : array
    {
        return $this->isVersion9() ? [
            'organizer',
            'command.make.repository'
        ] : [
            'organizer',
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
        // Bind Organizer Service
        $this->app->singleton(
            'organizer',
            function (Container $app) {
                return new Organizer($app['files'], $app['config']);
            }
        );

        // Bind Command Services
        if (!$this->isVersion9()) {
            $this->app->singleton(
                'command.make.model',
                function (Container $app) {
                    return new ModelMake($app['files'], $app['config']);
                }
            );
        }

        $this->app->singleton(
            'command.make.repository',
            function (Container $app) {
                return new RepositoryMake($app['files'], $app['config']);
            }
        );

        $this->app->singleton(
            'command.make.repository-interface',
            function (Container $app) {
                return new RepositoryClassMake($app['files'], $app['config']);
            }
        );

        $this->app->singleton(
            'command.make.repository-class',
            function (Container $app) {
                return new RepositoryInterfaceMake($app['files'], $app['config']);
            }
        );
    }
    
    protected function isVersion9 () : bool {
        return str_starts_with($this->app->version(), '9');
    }
}
