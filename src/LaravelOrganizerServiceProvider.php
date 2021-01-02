<?php

/**
 * Laravel Organizer Service Provider
 *
 * @author    Jonson B. <www.jbc.bd@gmail.com>
 * @copyright 2021 Jonson B. (https://who-jonson.tech)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/who-jonson/laravel-organizer
 */

namespace WhoJonson\LaravelOrganizer;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

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
        $configPath = __DIR__ . '/../config/laravel-organizer.php';
        $this->mergeConfigFrom($configPath, 'laravel-organizer');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['command.make.model'];
    }
}
