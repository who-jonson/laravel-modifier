<?php


namespace WhoJonson\LaravelOrganizer\Console\Commands;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;

class RepositoryClassMake extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:repository-class';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

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
        $namespace = $this->config->get('laravel-organizer.directories.repository', 'Repositories');
        /*if($ns = $this->option('ns')) {
            $namespace = $ns;
        }*/
        return parent::getDefaultNamespace("{$rootNamespace}\\{$namespace}");
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/../../Stubs/Repository.stub';
    }
}
