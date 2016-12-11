<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'pages'], function (Router $router) {

    $router->get('/', ['as' => 'admin.pages.manager', 'uses' => 'ManagerController@manager']);
});
