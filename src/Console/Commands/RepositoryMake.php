<?php

namespace WhoJonson\LaravelOrganizer\Console\Commands;


use Exception;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Config\Repository as Config;
use WhoJonson\LaravelOrganizer\LaravelOrganizer;

/**
 * Class RepositoryMake
 * @package WhoJonson\LaravelOrganizer\Console\Commands
 */
class RepositoryMake extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'make:repository {name} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new Repository with Interface & Bind in AppServiceProvider';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var LaravelOrganizer
     */
    protected $organizer;

    /**
     * @param Filesystem $files
     * @param Config $config
     *
     * @throws Exception
     */
    public function __construct(Filesystem $files, Config $config)
    {
        parent::__construct();

        $this->files = $files;
        $this->config = $config;
        $this->organizer = new LaravelOrganizer($files, $config);
    }

    /**
     * Execute the console command.
     *
     * @return mixed|void
     */
    public function handle()
    {
        $repository = Str::studly($this->argument('name'));

        $this->line('Creating: "' . $repository . '" Interface');
        $this->call('make:repository-interface', [
            'name'  => $repository
        ]);

        $this->line('Creating: "' . $repository . '" Class');
        $this->call('make:repository-class', [
            'name'      => $repository,
            '--model'   => $this->option('model')
        ]);

        $this->bind($repository);
    }


    /**
     * @param string $name
     */
    protected function bind(string $name) {
        $namespace = "App\\{$this->config->get('laravel-organizer.directories.repository', 'Repositories')}";

        try {
            $this->organizer->bindRepositoryClassInterface("{$namespace}\\Contracts\\{$name}", "{$namespace}\\{$name}");
        } catch (Exception $e) {
            $this->error('Error in binding the repository!');
            $this->error($e->getMessage());
        }
    }
}
