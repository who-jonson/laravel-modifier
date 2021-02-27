<?php


namespace WhoJonson\LaravelOrganizer\Console\Commands;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use WhoJonson\LaravelOrganizer\Exceptions\InvalidClassException;
use WhoJonson\LaravelOrganizer\Repositories\Repository;
use WhoJonson\LaravelOrganizer\Traits\CommandGenerator;

/**
 * Class RepositoryClassMake
 * @package WhoJonson\LaravelOrganizer\Console\Commands
 */
class RepositoryClassMake extends GeneratorCommand
{
    use CommandGenerator;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository-class {name} {--model=}';


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
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = true;

    /**
     * @var Config
     */
    protected $config;

    /**
     * RepositoryClassMake constructor
     *
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
     * @param $rootNamespace
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
     * Build the class with the given name.
     *
     * @param $name
     * @return string
     *
     * @throws FileNotFoundException|InvalidClassException
     */
    protected function buildClass($name): string
    {
        $stub = $this->replaceInterface(
            parent::buildClass($name)
        );
        $stub = $this->replaceBaseClass($stub);

        $model = $this->option('model');

        return $model ? $this->replaceModel($stub, $model) : $stub;
    }

    /**
     * Replace the Repository Interface
     *
     * @param  string  $stub
     * @return string
     */
    protected function replaceInterface(string $stub) : string
    {
        $namespace = $this->getDefaultNamespace(trim($this->rootNamespace(), '\\'));
        return str_replace('NamespacedDummyInterface', "{$namespace}\\Contracts\\{$this->getNameInput()}", $stub);
    }

    /**
     * Replace the model for the given stub.
     *
     * @param  string  $stub
     * @param  string  $model
     * @return string
     */
    protected function replaceModel(string $stub, string $model) : string
    {
        $model = str_replace('/', '\\', $model);

        $namespacedModel = trim($this->rootNamespace(), '\\');
        $defaultModelNamespace =  trim($this->config->get('laravel-organizer.directories.model', 'Models'), '\\');

        $namespacedModel .= "\\{$defaultModelNamespace}\\{$model}";

        $stub = str_replace('NamespacedDummyModel', $namespacedModel, $stub);
        return str_replace('DummyModel', $model, $stub);
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
        $className = $this->getBaseNamespacedClass(Repository::class, $this->config->get('laravel-organizer.classes.base_repository'));

        return str_replace(
            'DummyBase',
            Str::afterLast($className, '\\'),
            str_replace('NamespacedDummyBase', $className, $stub)
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return $this->option('model')
            ? __DIR__ . '/../../Stubs/repository.model.stub'
            : __DIR__ . '/../../Stubs/repository.stub';
    }
}
