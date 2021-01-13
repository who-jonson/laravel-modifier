<?php

/**
 * Laravel Organizer Exception
 *
 * @author    Jonson B. <www.jbc.bd@gmail.com>
 * @copyright 2021 Jonson B. (https://who-jonson.github.io)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/who-jonson/laravel-organizer
 */

namespace WhoJonson\LaravelOrganizer\Exceptions;

use Exception;

/**
 * Abstract Class LaravelOrganizerException
 * @package WhoJonson\LaravelOrganizer\Exceptions
 */
abstract class LaravelOrganizerException extends Exception
{
    /**
     * LaravelOrganizerException constructor.
     *
     * @param string $message [optional]
     * @param int $code [optional]
     * @param Exception|null $previous [optional]
     */
    public function __construct(string $message = 'Uncaught Reference Error!', int $code = E_USER_ERROR, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
