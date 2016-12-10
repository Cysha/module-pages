<?php namespace Cms\Modules\Pages\Models;

use Cms\Modules\Core\Models\BaseModel as CoreBaseModel;

class BaseModel extends CoreBaseModel
{

    public function __construct()
    {
        parent::__construct();

        $prefix = config('cms.pages.config.table-prefix', 'pages_');
        $this->table = $prefix.$this->table;
    }

}
