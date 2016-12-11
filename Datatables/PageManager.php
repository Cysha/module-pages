<?php

namespace Cms\Modules\Pages\Datatables;

class PageManager
{
    public function boot()
    {
        return [
            /*
             * Page Decoration Values
             */
            'page' => [
                'title' => 'Page Manager',
                'alert' => [
                    'class' => 'info',
                    'text' => '<i class="fa fa-info-circle"></i> You can manage your Pages from here.',
                ],
                'header' => [
                    /*[
                        'btn-text' => 'Create Page',
                        'btn-route' => 'admin.pages.create',
                        'btn-class' => 'btn btn-info btn-labeled',
                        'btn-icon' => 'fa fa-plus',
                    ],*/
                ],
            ],

            /*
             * Set up some table options, these will be passed back to the view
             */
            'options' => [
                'pagination' => false,
                'searching' => false,
                'ordering' => false,
                'sort_column' => 'order',
                'sort_order' => 'desc',
                'source' => 'admin.pages.manager',
                'collection' => function () {
                    $model = 'Cms\Modules\Pages\Models\Page';

                    return $model::all();
                },
            ],

            /*
             * Lists the tables columns
             */
            'columns' => [
                'title' => [
                    'th' => 'Title',
                    'tr' => function ($model) {
                        return $model->title;
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '15%',
                ],

                'slug' => [
                    'th' => 'Slug',
                    'tr' => function ($model) {
                        return sprintf('<a href="%s">%s</a>', $model->slug, $model->slug);
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '15%',
                ],

                'actions' => [
                    'th' => 'Actions',
                    'tr' => function ($model) {
                        $return = [
                        ];
                            // [
                            //     'btn-title' => 'Edit Category',
                            //     'btn-link' => route('backend.forum.category.update', $model->id),
                            //     'btn-class' => 'btn btn-warning btn-xs btn-labeled',
                            //     'btn-icon' => 'fa fa-pencil',
                            //     'hasPermission' => 'update@forum_backend',
                            // ],

                        return $return;
                    },
                ],
            ],
        ];
    }
}
