<?php

namespace Cms\Modules\Pages\Http\Controllers\Backend\PageCreate;

use Cms\Modules\Pages\Repositories\Page\RepositoryInterface as PageRepository;
use Cms\Modules\Pages\Http\Controllers\Backend\BaseController;
use Cms\Modules\Pages\Http\Requests\BackendCreatePageRequest;
use Cms\Modules\Core\Models\Theme;

class PageCreateController extends BaseController
{
    public function getForm()
    {
        $this->editorAssets();
        $sections = [];

        $layouts = [];
        foreach (Theme::getLayouts() as $layout) {
            $layouts[$layout] = ['value' => $layout];
        }

        return $this->setView('backend.page.form', compact('layouts', 'sections'));
    }

    public function postForm(BackendCreatePageRequest $request, PageRepository $page)
    {
        $input = $request->except('_token');

        if ($page->slugExists(array_get($input, 'slug'))) {
            return redirect()
                ->back()
                ->withInput()
                ->withError('Error, slug already exists, pick another.');
        }

        $createdPage = $page->create($input);
        if ($createdPage === null) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($createdPage->errors());
        }

        return redirect(route('admin.pages.edit', $createdPage->id))
            ->withInfo('Page created successfully.');
    }
}
