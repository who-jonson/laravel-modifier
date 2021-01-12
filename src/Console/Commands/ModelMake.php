<?php


namespace WhoJonson\LaravelOrganizer\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\ModelMakeCommand;
use Illuminate\Contracts\Config\Repository as Config;

/**
 * Class ModelMake
 * @package WhoJonson\LaravelOrganizer\Console\Commands
 */
class ModelMake extends ModelMakeCommand
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @param Filesystem $files
     * @param Config $config
     */
    public function __construct(Filesystem $files, Config $config)
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
        return parent::getDefaultNamespace("{$rootNamespace}\\{$namespace}");
    }

}
