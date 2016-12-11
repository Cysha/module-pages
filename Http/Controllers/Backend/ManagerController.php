<?php

namespace Cms\Modules\Pages\Http\Controllers\Backend;

use Cms\Modules\Admin\Traits\DataTableTrait;
use Cms\Modules\Pages\Datatables\PageManager;

class ManagerController extends BaseController
{
    use DataTableTrait;

    public function manager()
    {
        $this->theme->breadcrumb()->add('Page Manager', route('admin.pages.manager'));

        return $this->renderDataTable(with(new PageManager())->boot());
    }
}
