<?php

return [

    /**
     * The api endpoints are being registered
     * under this prefix.
     */
    'api_prefix' => 'api',

    /**
     * This middleware stack is being
     * used for all api routes.
     */
    'api_middleware' => ['api'],

    /**
     * The admin endpoints are being registered
     * under this prefix.
     */
    'admin_prefix' => 'admin',

    /**
     * This middleware stack is being
     * used for all api routes.
     */
    'admin_middleware' => ['web', 'auth'],

];
