<?php

/**
 * Class OrganizerAssistant
 *
 * @author    Jonson B. <www.jbc.bd@gmail.com>
 * @copyright 2021 Jonson B. (https://who-jonson.github.io)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/who-jonson/laravel-organizer
 */

namespace WhoJonson\LaravelOrganizer;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Config\Repository as Config;
use WhoJonson\LaravelOrganizer\Exceptions\AppConfigNotFoundException;
use WhoJonson\LaravelOrganizer\Exceptions\ProvidersNotFoundException;

/**
 * Class OrganizerAssistant
 * @package WhoJonson\LaravelOrganizer
 */
class OrganizerAssistant
{
    /**
     * The Laravel framework version.
     *
     * @var int
     */
    protected $version;

    /**
     * @var Config
     */
    protected $config;

    /**
     * LaravelOrganizer constructor.
     *
     * @param Config $config
     * @throws Exception
     */
    public function __construct(Config $config)
    {
        $this->version = (int) \Str::before(app()->version(), '.');
        $this->config = $config;

        $this->setUp();
    }

    /**
     * Setup Config
     *
     * @throws Exception
     */
    private function setUp()
    {
        if (!$this->config->has('laravel-organizer')) {
            throw new Exception('Configuration parameters not loaded!');
        }
    }

    /**
     * @param array $config
     *
     * @return OrganizerAssistant
     */
    public function setConfig(array $config) : OrganizerAssistant
    {
        $this->config = $config;
        return $this;
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

        if ($this->config->get('laravel-organizer.register_on_boot', $this->version < 9)) {
            return $this->registerBindingsOnBoot($file, $abstract, $concrete);
        }
        return $this->registerBindings($file, $abstract, $concrete);
    }

    /**
     * @param string $file
     * @param string $abstract
     * @param string $concrete
     *
     * @return bool
     */
    protected function registerBindings(string $file, string $abstract, string $concrete) : bool
    {
        $contents = file($file);
        $appendAt = $this->appendAt($contents, 'public $bindings =');
        if($appendAt > 0) {
            $insert = [
                "        \\{$abstract}::class => \\{$concrete}::class,\n"
            ];

            array_splice($contents, $appendAt, 0, $insert);
            file_put_contents($file, $contents);

            return true;
        }
        return false;
    }

    /**
     * @param string $file
     * @param string $abstract
     * @param string $concrete
     *
     * @return bool
     */
    protected function registerBindingsOnBoot(string $file, string $abstract, string $concrete) : bool
    {
        $contents = file($file);
        $appendAt = $this->appendAt($contents, 'public function boot()', '{');
        if($appendAt > 0) {
            $insert = [
                '        $this->app->bind(' . "\n",
                "            '" . $abstract . "',\n",
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
     *
     * @throws AppConfigNotFoundException
     * @throws ProvidersNotFoundException
     */
    protected function getRepositoryServiceProvider(): string
    {
        if(!class_exists($class = 'App\Providers\RepositoryServiceProvider')) {
            Artisan::call('make:provider', [
                'name'        => 'RepositoryServiceProvider',
                '--organizer' => true
            ]);
            $this->registerProvider($class);
        }
        return app_path('Providers/RepositoryServiceProvider.php');
    }

    /**
     * Add a ServiceProvider in the providers array of application config
     *
     * @param string $name
     *
     * @throws AppConfigNotFoundException
     * @throws ProvidersNotFoundException
     */
    protected function registerProvider(string $name)
    {
        $file = config_path('app.php');
        if(!file_exists($file)) {
            throw new AppConfigNotFoundException();
        }

        $providers = $this->config->get('app.providers');
        if(!$providers || !is_array($providers)) {
            throw new ProvidersNotFoundException();
        }

        if(in_array($name, $providers)) {
            return;
        }

        $contents = file($file);
        $appendAt = $this->appendAt($contents, end($providers));

        if($appendAt > 0) {
            $index = $appendAt - 1;

            $replace = Str::afterLast($contents[$index], ' ');
            $replace = Str::beforeLast($replace, '\n');

            $insert[] = "\n";
            $insert[] = str_replace($replace, "App\Providers\RepositoryServiceProvider::class,\n", $contents[$index]);

            array_splice($contents, $appendAt, 0, $insert);
            file_put_contents($file, $contents);

            exec('composer dump-autoload');
        }
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
