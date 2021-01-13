<?php


namespace WhoJonson\LaravelOrganizer\Exceptions;


/**
 * Class AppConfigNotFoundException
 * @package WhoJonson\LaravelOrganizer\Exceptions
 */
class AppConfigNotFoundException extends LaravelOrganizerException
{

    /**
     * AppConfigNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Application config file "config/app.php" not found!');
    }
}
