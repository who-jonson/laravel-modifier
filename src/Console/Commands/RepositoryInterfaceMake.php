<?php


namespace WhoJonson\LaravelOrganizer\Console\Commands;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;

/**
 * Class RepositoryInterfaceMake
 * @package WhoJonson\LaravelOrganizer\Console\Commands
 */
class RepositoryInterfaceMake extends GeneratorCommand
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository-interface {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Repository Interface';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'RepositoryInterface';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = true;

    /**
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
     * @param $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) : string
    {
        $namespace = $this->config->get('laravel-organizer.directories.repository', 'Repositories');
        return parent::getDefaultNamespace("{$rootNamespace}\\{$namespace}\\Contracts");
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/../../Stubs/repositoryInterface.stub';
    }
}
