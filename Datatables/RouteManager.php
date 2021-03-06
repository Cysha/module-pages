<?php

namespace Cms\Modules\Pages\Datatables;

use Illuminate\Support\Facades\Route;

class RouteManager
{
    public function boot()
    {
        return [
            /*
             * Page Decoration Values
             */
            'page' => [
                'title' => 'Route Manager',
            ],

            /*
             * Set up some table options, these will be passed back to the view
             */
            'options' => [
                'pagination' => true,
                'searching' => false,
                'ordering' => false,
                'sort_column' => 'name',
                'sort_order' => 'desc',
                'source' => 'admin.route.manager',
                'collection_type' => 'collection',
                'collection' => function () {

                    return collect(Route::getRoutes()->getIterator())->map(function ($route) {
                        return (object) [
                            'methods' => $route->methods(),
                            'name' => $route->getName(),
                            'domain' => $route->domain() ?: null,
                            'uri' => $route->uri(),
                            'actionName' => $route->getActionName(),
                            'middleware' => $route->middleware(),
                        ];
                    });
                },
            ],

            /*
             * Lists the tables columns
             */
            'columns' => [

                'methods' => [
                    'th' => 'Methods',
                    'tr' => function ($model) {
                        $methodColors = [
                            'GET' => 'success',
                            'HEAD' => 'default',
                            'POST' => 'primary',
                            'PUT' => 'warning',
                            'PATCH' => 'info',
                            'DELETE' => 'danger',
                        ];

                        return collect($model->methods)->map(function ($method) use ($methodColors) {
                            return sprintf('<span class="label label-%s">%s</span>', array_get($methodColors, $method), $method);
                        })->implode(' ');
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '10%',
                ],

                'uri' => [
                    'th' => 'URL',
                    'tr' => function ($model) {
                        return $model->uri;
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '20%',
                ],

                'name' => [
                    'th' => 'Route Name',
                    'tr' => function ($model) {
                        return $model->name;
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '20%',
                ],

                'actionName' => [
                    'th' => 'Class Action',
                    'tr' => function ($model) {

                        $actionName = explode('@', $model->actionName);
                        $class = $actionName[0];
                        $method = $actionName[1] ?? '';


                        $className = explode('\\', $class);
                        $className = last($className);
                        return sprintf('<span title="%2$s" data-toggle="tooltip">%1$s@%3$s</span>', $className, $class, $method);
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '20%',
                ],

                'middleware' => [
                    'th' => 'Middleware',
                    'tr' => function ($model) {
                        return collect($model->middleware)->map(function ($row) {
                            return sprintf('<span class="label label-default">%s</span>', $row);
                        })->implode(' ');
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '7%',
                ],

            ],
        ];
    }
}
