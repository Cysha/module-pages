<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'pages'], function (Router $router) {

    $router->group(['prefix' => 'create', 'namespace' => 'PageCreate'], function (Router $router) {
        $router->post('/', ['uses' => 'PageCreateController@postForm']);
        $router->get('/', ['as' => 'admin.pages.create', 'uses' => 'PageCreateController@getForm']);
    });
    $router->group(['prefix' => '{backend_pages_page_id}', 'namespace' => 'PageUpdate'], function (Router $router) {
        $router->post('/', ['uses' => 'PageUpdateController@postForm']);
        $router->get('/', ['as' => 'admin.pages.update', 'uses' => 'PageUpdateController@getForm']);
    });

    $router->get('/', ['as' => 'admin.pages.manager', 'uses' => 'PageManagerController@manager']);
});

$router->group(['prefix' => 'routes'], function (Router $router) {
    $router->get('/', ['as' => 'admin.route.manager', 'uses' => 'RouteManagerController@manager']);
});
