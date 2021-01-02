<?php


namespace WhoJonson\LaravelOrganizer\Console\Commands;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\ModelMakeCommand;

class MakeModel extends ModelMakeCommand
{
    /**
     * @var Config
     */
    protected $config;

    /**
     *
     * @param Filesystem $files
     * @param Config $config
     */
    public function __construct(Filesystem $files, Config $config)
    {
        parent::__construct($files);

        $this->config = $config;
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
