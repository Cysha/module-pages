<?php

namespace Cms\Modules\Pages\Repositories\Page;

use Cms\Modules\Core\Repositories\BaseEloquentRepository;

class EloquentRepository extends BaseEloquentRepository implements RepositoryInterface
{
    public function getModel()
    {
        return 'Cms\Modules\Pages\Models\Page';
    }

    public function slugExists($slug, $id = 0)
    {
        $exists = $this->model
            ->whereSlug($slug);

        // when id is set, exclude it from the results
        if ($id > 0) {
            $exists->where('id', '<>', $id);
        }

        return $exists->get()->first() === null ? false : true;
    }
}
