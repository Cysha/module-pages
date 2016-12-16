<?php

namespace Cms\Modules\Pages\Http\Controllers\Backend;

use Cms\Modules\Pages\Datatables\RouteManager;
use Cms\Modules\Admin\Traits\DataTableTrait;

class RouteManagerController extends BaseController
{
    use DataTableTrait;

    public function manager()
    {
        $this->theme->breadcrumb()->add('Route Manager', route('admin.route.manager'));

        return $this->renderDataTable(with(new RouteManager())->boot());
    }
}
