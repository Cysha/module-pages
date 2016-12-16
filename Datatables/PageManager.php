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
                    [
                        'btn-text' => 'Create Page',
                        'btn-route' => 'admin.pages.create',
                        'btn-class' => 'btn btn-info btn-labeled',
                        'btn-icon' => 'fa fa-plus',
                    ],
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

                    return $model::with('content');
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
                        return sprintf('<a href="%s">%s</a>', '/'.$model->slug, $model->slug);
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '15%',
                ],

                'active' => [
                    'th' => 'Active',
                    'tr' => function ($model) {
                        return $model->active === true
                            ? '<div class="label label-success">Active</div>'
                            : '<div class="label label-danger">Not Active</div>';
                    },
                    'tr-class' => 'text-center',
                    'width' => '5%',
                ],

                'sections' => [
                    'th' => 'Sections',
                    'tr' => function ($model) {
                        $sections = config('cms.pages.editor.sections');
                        $colors = config('cms.pages.editor.section_colors');

                        $labels = [];
                        foreach ($sections as $section) {
                            $section = strtolower($section);
                            $content = $model->getSection($section);
                            \Log::info([$model->id, $section, $content]);
                            if ($content !== false) {
                                $labels[] = sprintf('<div class="label label-%s">%s</div>', array_get($colors, $section, 'default'), $section);
                            }
                        }

                        return implode(' ', $labels);
                    },
                    'orderable' => true,
                    'searchable' => true,
                    'width' => '15%',
                ],

                'actions' => [
                    'th' => 'Actions',
                    'tr' => function ($model) {
                        $return = [
                            [
                                'btn-title' => 'Edit',
                                'btn-link' => route('admin.pages.update', $model->id),
                                'btn-class' => 'btn btn-warning btn-xsprimary btn-labeled',
                                'btn-icon' => 'fa fa-pencil',
                                'hasPermission' => 'update@pages_backend',
                            ],
                        ];

                        return $return;
                    },
                ],
            ],
        ];
    }
}
