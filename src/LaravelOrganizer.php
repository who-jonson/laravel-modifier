<?php

namespace WhoJonson\LaravelOrganizer;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

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
     * @return string
     */
    protected function getRepositoryServiceProvider(): string
    {
        $file = class_exists('App\Providers\RepositoryServiceProvider')
            ? app_path('Providers/RepositoryServiceProvider.php')
            : false;

        if(!$file || !realpath($file)) {
            Artisan::call('make:provider RepositoryServiceProvider');
        }
        return app_path('Providers/RepositoryServiceProvider.php');
    }

    /**
     * @param string $abstract
     * @param string $concrete
     * @return bool
     * @throws Exception
     */
    public function bindRepositoryClassInterface(string $abstract, string $concrete): bool
    {
        if(!interface_exists($abstract)) {
            throw new Exception('"' . $abstract . '" not found!');
        }
        if(!class_exists($concrete)) {
            throw new Exception('"' . $concrete . '" not found!');
        }
        $file = $this->getRepositoryServiceProvider();
        $contents = file($file);
        $index = -1;
        foreach ($contents as $key => $value) {
            if(str_contains($value, 'public function boot()')) {
                $index = $key;
                break;
            }
        }

        if($index >= 0) {
            $appendAt = 0;
            if(str_contains(Str::after($contents[$index], 'public function boot()'), '{')) {
                $appendAt = $index + 1;
            } else {
                for ($i = $index + 1; $i < count($contents); $i++) {
                    if (str_contains($contents[$i], '{')) {
                        $appendAt = $i + 1;
                        break;
                    }
                }
            }

            $insert = [
                '        $this->app->bind(' . "\n",
                "            '" . $abstract ."',\n",
                "            '" . $concrete . "'\n",
                '        );' . "\n",
                "\n"
            ];

            array_splice($contents, $appendAt, 0, $insert);
            file_put_contents($file, $contents);

            return true;
        }
        return false;
    }
}
