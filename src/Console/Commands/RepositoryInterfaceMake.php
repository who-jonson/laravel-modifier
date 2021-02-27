<?php


namespace WhoJonson\LaravelOrganizer\Console\Commands;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use WhoJonson\LaravelOrganizer\Contracts\Repository;
use WhoJonson\LaravelOrganizer\Exceptions\InvalidClassException;
use WhoJonson\LaravelOrganizer\Traits\CommandGenerator;

/**
 * Class RepositoryInterfaceMake
 * @package WhoJonson\LaravelOrganizer\Console\Commands
 */
class RepositoryInterfaceMake extends GeneratorCommand
{
    use CommandGenerator;

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
     * RepositoryInterfaceMake constructor
     *
     * @param Filesystem $files
     * @param Config $config
     */
    public function __construct(Filesystem $files, Config $config) {
        parent::__construct($files);

        $this->config = $config;
    }

    /**
     * Prefix default root namespace with a Directory.
     *
     * @param $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace) : string {
        $namespace = $this->config->get('laravel-organizer.directories.repository', 'Repositories');
        return parent::getDefaultNamespace("{$rootNamespace}\\{$namespace}\\Contracts");
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string {
        return __DIR__ . '/../../Stubs/repository-interface.stub';
    }

    /**
     * Build the class with the given name.
     *
     * @param $name
     * @return string
     *
     * @throws FileNotFoundException|InvalidClassException
     */
    protected function buildClass($name): string {
        return $this->replaceBaseClass(
            parent::buildClass($name)
        );
    }

    /**
     * Replace the base repository for the given stub.
     *
     * @param string $stub
     *
     * @return string
     * @throws InvalidClassException
     */
    protected function replaceBaseClass(string $stub) : string {
        $className = $this->getBaseNamespacedClass(Repository::class, $this->config->get('laravel-organizer.classes.base_repository_interface'));

        return str_replace(
            'DummyBase',
            Str::afterLast($className, '\\'),
            str_replace('NamespacedDummyBase', $className, $stub)
        );
    }
}
