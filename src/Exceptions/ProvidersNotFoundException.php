<?php


namespace WhoJonson\LaravelOrganizer\Exceptions;


/**
 * Class ProvidersNotFoundException
 * @package WhoJonson\LaravelOrganizer\Exceptions
 */
class ProvidersNotFoundException extends LaravelOrganizerException
{

    /**
     * ProvidersNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Application Providers array not found in "config/app.php" file!');
    }
}
