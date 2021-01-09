<?php


namespace WhoJonson\LaravelOrganizer\Console\Commands;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\ModelMakeCommand;

class ModelMake extends ModelMakeCommand
{
    /**
     * @var Config
     */
    protected $config;

    /**
     *
     * @param Config $config
     * @param Filesystem $files
     */
    public function __construct(Config $config, Filesystem $files)
    {
        $this->config = $config;
        parent::__construct($files);
    }

    /**
     * Prefix default root namespace with a Directory.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        $namespace = $this->config->get('laravel-organizer.directories.model', 'Models');
        if($ns = $this->option('ns')) {
            $namespace = $ns;
        }
        return parent::getDefaultNamespace("{$rootNamespace}\\{$namespace}");
    }

}
