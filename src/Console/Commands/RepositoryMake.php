<?php

namespace WhoJonson\LaravelOrganizer\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Filesystem\Filesystem;

class RepositoryMake extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new Repository with Interface & Bind in AppServiceProvider';

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @var Filesystem
     */
    protected Filesystem $files;

    /**
     *
     * @param Config $config
     * @param Filesystem $files
     */
    public function __construct(Config $config, Filesystem $files)
    {
        $this->config = $config;
        $this->files = $files;

        parent::__construct();
    }
}
