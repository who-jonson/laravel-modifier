<?php

/**
 * Class Organizer
 *
 * @author    Jonson B. <www.jbc.bd@gmail.com>
 * @copyright 2021 Jonson B. (https://who-jonson.github.io)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/who-jonson/laravel-organizer
 */

namespace WhoJonson\LaravelOrganizer;


use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Config\Repository as Config;

/**
 * Class Organizer
 * @package WhoJonson\LaravelOrganizer
 */
class Organizer
{
    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var Config
     */
    protected $config;

    /**
     * LaravelOrganizer constructor.
     *
     * @param Filesystem $files
     * @param Config $config
     *
     * @throws Exception
     */
    public function __construct(Filesystem $files, Config $config)
    {
        $this->files = $files;
        $this->config = $config;

        $this->setUp();
    }

    /**
     * Setup
     *
     * @throws Exception
     */
    private function setUp()
    {
        if (!$this->config->has('laravel-organizer')) {
            throw new Exception('Configuration parameters for "Laravel Organizer" are not loaded!');
        }
    }

}
