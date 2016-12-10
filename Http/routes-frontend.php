<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'pages'], function (Router $router) {
    $router->get('/', ['as' => 'pxcms.pages.index', 'uses' => 'PagesController@getIndex']);
});
