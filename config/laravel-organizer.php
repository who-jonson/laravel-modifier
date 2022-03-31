<?php

return [
    'directories'   => [
        /*
         * Default NameSpace for Models
         *
         * example: to keep your Models in "app/Models" directory as Namespaced "App\Models"
         * then the value should be "Models"
         *
         * OR to keep your Models in "app/Custom/Models" directory as Namespaced "App\Custom\Models"
         * then the value should be "Custom\\Models"
         */
        'model' => 'Models',

        /*
         * Default NameSpace for Repositories
         *
         * example: to keep your Repositories in "app/Repositories" directory as Namespaced "App\Repositories"
         * then the value should be "Repositories"
         *
         * OR to keep your Repositories in "app/Custom/Repositories" directory as Namespaced "App\Custom\Repositories"
         * then the value should be "Custom\\Repositories"
         */
        'repository' => 'Repositories',

        /*
         * Default NameSpace for Repository Interfaces
         */
        'interface' => 'Repositories\\Contracts'
    ]
];
