<?php


namespace WhoJonson\LaravelOrganizer\Exceptions;


/**
 * Class UndefinedModelException
 * @package WhoJonson\LaravelOrganizer\Exceptions
 */
class UndefinedModelException extends LaravelOrganizerException
{

    /**
     * UndefinedModelException constructor.
     */
    public function __construct()
    {
        parent::__construct('Model not defined when the class initiated!');
    }
}
