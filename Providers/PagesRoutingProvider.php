<?php

namespace Cms\Modules\Pages\Providers;

use Cms\Modules\Core\Providers\CmsRoutingProvider;
use Cms\Modules\Pages\Models\Page;
use Illuminate\Routing\Router;

class PagesRoutingProvider extends CmsRoutingProvider
{
    protected $namespace = 'Cms\Modules\Pages\Http\Controllers';

    /**
     * @return string
     */
    protected function getFrontendRoute()
    {
        return __DIR__.'/../Http/routes-frontend.php';
    }

    /**
     * @return string
     */
    protected function getBackendRoute()
    {
        return __DIR__.'/../Http/routes-backend.php';
    }

    /**
     * @return string
     */
    protected function getApiRoute()
    {
        return __DIR__.'/../Http/routes-api.php';
    }

    public function boot(Router $router)
    {
        parent::boot($router);

        $router->bind('pages_page_slug', function ($slug) {
           return with(new Page())
                ->with('content')
                ->where('slug', $slug)
                ->firstOrFail();
        });
    }
}
