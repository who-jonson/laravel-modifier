<?php

/**
 * Organizer Facade
 *
 * @author    Jonson B. <www.jbc.bd@gmail.com>
 * @copyright 2021 Jonson B. (https://who-jonson.github.io)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/who-jonson/laravel-organizer
 */

namespace WhoJonson\LaravelOrganizer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Organizer
 * @package WhoJonson\LaravelOrganizer\Facades
 */
class Organizer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor() : string
    {
        return 'organizer';
    }
}
