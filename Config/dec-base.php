<?php

return [

    /**
     * Policy settings for the application
     * To help determine the policy verb to use
     *
     * Set your custom verbs in the policyVerbs
     * array below.
     * ['default', 'voyager', custom]
     */
    'permissionManager' => 'voyager',

    /**
     * Policy redirect route when user
     * has not been authenticated
     */
    'unAuthRoute' => '/login',

    /**
     * Set custom policy permission verbs
     * This is laravel's default policy verbs
     * for each controller method
     *
     * Uncomment all and edit necessary ones to change
     */
    // 'permission' => [
    //     'index' => 'viewAny',
    //     'show' => 'view',
    //     'edit' => 'update',
    //     'update' => 'update',
    //     'create' => 'store',
    //     'store' => 'store',
    //     'delete' => 'delete',
    //     'destroy' => 'delete',
    //     'forceDelete' => 'forceDelete',
    // ]

    /**
     * Redirect route for unauthenticated
     */
    'unAuthRoute' => '/login',

    /**
     * Event service provider directory
     */
    'EventDirectory' => 'App\Providers\\',

    /**
     * Set permission table
     */
    'permissionTable' => 'permissions',

    /**
     * Set pagination limit
     */
    'paginationLimit' => 15,
];

?>
