<?php


namespace WhoJonson\LaravelOrganizer\Exceptions;


/**
 * Class InvalidClassException
 * @package WhoJonson\LaravelOrganizer\Exceptions
 */
class InvalidClassException extends LaravelOrganizerException
{
    /**
     * InvalidClassException constructor.
     *
     * @param string $message
     */
    public function __construct(string $message = 'Invalid Class Definition!')
    {
        parent::__construct($message);
    }
}