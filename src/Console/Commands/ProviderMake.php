<?php


namespace WhoJonson\LaravelOrganizer\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\ProviderMakeCommand;
use Illuminate\Contracts\Config\Repository as Config;

/**
 * Class ModelMake
 * @package WhoJonson\LaravelOrganizer\Console\Commands
 */
class ProviderMake extends ProviderMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:provider {name} {--O|organizer}';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if (!$this->option('organizer')) {
            return parent::getStub();
        }

        return ((int) \Str::before(app()->version(), '.')) <= 7
            ? __DIR__ . '/../../Stubs/provider-6.stub'
            : __DIR__ . '/../../Stubs/provider.stub';
    }

}
