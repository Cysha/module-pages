<?php

namespace Cms\Modules\Pages\Models;

class Page extends BaseModel
{
    public $table = 'pages';
    public $fillable = [
        'title', 'slug', 'layout',
    ];
    protected $identifiableName = 'title';
    protected $link = [
        'route' => 'pxcms.pages.viewpage',
        'attributes' => ['slug'],
    ];

    public function content()
    {
        return $this->hasMany(__NAMESPACE__.'\Content')
            ->where('published', true)
            ->groupBy('section');
    }

    public function getSection($part)
    {
        $sections = $this->getRelation('content');

        $section = $sections->filter(function ($section) use ($part) {
            if (strtolower($section->section) === strtolower($part)) {
                return true;
            }
        });

        return $section->count() === 0 ? false : $section->first()->transform();
    }

    public function transform()
    {
        $data = [
            'id' => (int) $this->id,
            'title' => (string) $this->title,
            'slug' => (string) $this->slug,
            'layout' => (string) $this->layout,

            'links' => [
                'self' => (string) $this->makeLink(true),
                'link' => (string) $this->makeLink(false),
            ],

            'content' => [],

            'created_at' => date_array($this->created_at),
            'updated_at' => date_array($this->updated_at),
        ];

        // if ($this->content !== null) {
            $data['content'] = [
                'view' => $this->getSection('view') ?: null,
                //'php' => $this->getSection('php') ?: null,
                'css' => $this->getSection('css') ?: null,
                'js' => $this->getSection('js') ?: null,
                'keywords' => $this->getSection('keywords') ?: null,
                'description' => $this->getSection('description') ?: null,
            ];
        // }

        return $data;
    }
}
