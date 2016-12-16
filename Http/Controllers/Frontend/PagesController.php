<?php

namespace Cms\Modules\Pages\Http\Controllers\Frontend;

use Cms\Modules\Pages\Models\Page;

class PagesController extends BaseController
{
    public function getPage(Page $page)
    {
        $this->setLayout($page->layout);
        $this->theme->setTitle($page->title);

        // apply the keywords and description to the page
        if (($section = $page->getSection('keywords')) !== false) {
            view()->composer('theme.*::views.partials.theme.head', function ($view) use ($section) {
                return $view->with('keywords', array_get($section, 'content', null));
            });
        }

        if (($section = $page->getSection('description')) !== false) {
            view()->composer('theme.*::views.partials.theme.head', function ($view) use ($section) {
                return $view->with('description', array_get($section, 'content', null));
            });
        }

        // add the custom js/css too
        if (($section = $page->getSection('css')) !== false) {
            $this->theme->asset()->writeStyle('page-style', array_get($section, 'content', null), 'css');
        }

        if (($section = $page->getSection('js')) !== false) {
            $this->theme->asset()->container('footer')->writeScript('page-script', array_get($section, 'content', null), 'js');
        }

        $page = $page->transform();

        return $this->setView('frontend.view-page', compact('page'));
    }

    /*public function getHome()
    {
        $this->setLayout('col-1');

        return $this->setView('home', [], 'module');
    }*/

    public function kitchenSink()
    {
        $this->setLayout('1-column');

        return $this->setView('bootstrap-kitchen-sink');
    }
}
