<?php


$router->get('kitchen-sink', ['uses' => 'PagesController@kitchenSink']);
$router->get('{pages_page_slug}', ['as' => 'pxcms.pages.viewpage', 'uses' => 'PagesController@getPage']);
