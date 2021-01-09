<?php

namespace WhoJonson\LaravelOrganizer\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\Str;
use WhoJonson\LaravelOrganizer\LaravelOrganizer;

class RepositoryMake extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new Repository with Interface & Bind in AppServiceProvider';

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var LaravelOrganizer
     */
    protected $organizer;

    /**
     *
     * @param Config $config
     * @param LaravelOrganizer $organizer
     */
    public function __construct(Config $config, LaravelOrganizer $organizer)
    {
        parent::__construct();

        $this->config = $config;
        $this->organizer = $organizer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed|void
     */
    public function handle()
    {
        $repository = Str::studly($this->argument('name'));

        $this->info('Creating: "' . $repository . '" Interface');
        $this->call('make:repository-interface', [
            'name'  => $repository
        ]);
        $this->line('Created: "' . $repository . '" Interface');

        $this->info('Creating: "' . $repository . '" Class');
        $this->call('make:repository-class', [
            'name'  => $repository
        ]);
        $this->line('Created: "' . $repository . '" Class');

        $this->bind($repository);
    }

    protected function bind(string $name) {
        $namespace = "App\\{$this->config->get('laravel-organizer.directories.repository', 'Repositories')}";

        try {
            $this->organizer->bindRepositoryClassInterface("{$namespace}\\Contracts\\{$name}", "{$namespace}\\{$name}");
        } catch (\Exception $e) {
            $this->error('Error in binding the repository!');
            $this->error($e->getMessage());
        }
    }
}
