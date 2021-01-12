<?php

/**
 * Laravel Organizer
 *
 * @author    Jonson B. <www.jbc.bd@gmail.com>
 * @copyright 2021 Jonson B. (https://who-jonson.github.io)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/who-jonson/laravel-organizer
 */

namespace WhoJonson\LaravelOrganizer;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Config\Repository as Config;

/**
 * Class LaravelOrganizer
 * @package WhoJonson\LaravelOrganizer
 */
class LaravelOrganizer
{
    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var Config
     */
    protected $config;

    /**
     * LaravelOrganizer constructor.
     * @param Filesystem $files
     * @param Config $config
     *
     * @throws Exception
     */
    public function __construct(Filesystem $files, Config $config)
    {
        $this->files = $files;
        $this->config = $config;

        $this->setUp();
    }

    /**
     * Setup
     *
     * @throws Exception
     */
    private function setUp()
    {
        if (!$this->config->has('laravel-organizer')) {
            throw new Exception('Configuration parameters for "Laravel Organizer" are not loaded!');
        }
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

        $appendAt = $this->appendAt($contents, 'public function boot()', '{');
        if($appendAt >= 0) {
            $insert = [
                '        $this->app->bind(' . "\n",
                "            '" . $abstract ."',\n",
                "            '" . $concrete . "'\n",
                '        );' . "\n"
            ];

            array_splice($contents, $appendAt, 0, $insert);
            file_put_contents($file, $contents);

            return true;
        }
        return false;
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
     * @param array $contents
     * @param string $search
     * @param string|null $after
     * @return int
     */
    protected function appendAt(array $contents, string $search, string $after = null) : int {
        $index = -1;
        foreach ($contents as $key => $value) {
            if(str_contains($value, $search)) {
                $index = $key;
                break;
            }
        }

        if($index >= 0) {
            if(!$after) {
                return $index + 1;
            }
            if(str_contains(Str::after($contents[$index], $search), $after)) {
                return $index + 1;
            }

            for ($i = $index + 1; $i < count($contents); $i++) {
                if (str_contains($contents[$i], $after)) {
                    return $i + 1;
                }
            }
        }
        return -1;
    }
}
