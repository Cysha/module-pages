<?php

namespace Cms\Modules\Pages\Http\Controllers\Backend;

use Cms\Modules\Admin\Traits\DataTableTrait;
use Cms\Modules\Pages\Datatables\RouteManager;
use Illuminate\Support\Facades\Route;

class RouteManagerController extends BaseController
{
    use DataTableTrait;

    public function manager()
    {
        // dd(collect(Route::getRoutes()->getIterator()));
        $this->theme->breadcrumb()->add('Route Manager', route('admin.route.manager'));

        return $this->renderDataTable(with(new RouteManager())->boot());
    }
}
