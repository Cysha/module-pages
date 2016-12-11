<?php

namespace Cms\Modules\Pages\Models;

use League\CommonMark\CommonMarkConverter;

class Content extends BaseModel
{
    public $table = 'page_content';
    public $fillable = [
        'page_id', 'author_id', 'section', 'content', 'version', 'published', 'view_count',
    ];
    public $casts = [
        'published' => 'boolean',
        'view_count' => 'integer',
    ];
    public $touches = [
        'page',
    ];

    public function author()
    {
        $authModel = config('auth.model');

        return $this->belongsTo($authModel);
    }

    public function page()
    {
        return $this->belongsTo(__NAMESPACE__.'\Page');
    }

    public function getContentAttribute($value)
    {
        switch (strtolower($this->section)) {
            /* probably not a good idea...
            case 'php':
                return $value;
            break;*/

            case 'view':
            case 'markdown':
                $value = replaceMentions($value);

                return escape(with(new CommonMarkConverter())->convertToHtml($value));
            break;

            case 'css':
            case 'js':
            case 'text':
            default:
                return $value;
            break;
        }
    }

    public function transform()
    {
        $data = [
            'id' => (int) $this->id,
            'section' => (string) $this->section,
            'content' => (string) $this->content,
            'version' => (string) $this->version,
            'published' => (bool) $this->published ?: false,
            'view_count' => (int) $this->view_count,

            'created_at' => date_array($this->created_at),
            'updated_at' => date_array($this->updated_at),

            'page' => [],
            'author' => [],
        ];

        // if ($this->page !== null) {
        //     $data['page'] = $this->page->transform();
        // }

        if ($this->author !== null) {
            $data['author'] = $this->author->transform();
        }

        return $data;
    }
}
