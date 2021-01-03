<?php

namespace WhoJonson\LaravelOrganizer;




use Illuminate\Support\Facades\Artisan;

class LaravelOrganizer
{
    public function __construct()
    {

    }

    /**
     * Check for App\Providers\RepositoryServiceProvider
     *
     * If not exists then create RepositoryServiceProvider class
     *
     * @return void
     */
    protected function checkForRepositoryServiceProvider()
    {
        $file = class_exists('App\Providers\RepositoryServiceProvider')
            ? app_path('Providers/RepositoryServiceProvider.php')
            : false;

        if(!$file || !realpath($file)) {
            Artisan::call('make:provider RepositoryServiceProvider');
        }
    }

    protected function bindRepositoryClassInterface() {}
}
