<?php

namespace Cms\Modules\Pages\Http\Controllers\Backend\PageUpdate;

use Cms\Modules\Core\Models\Theme;
use Cms\Modules\Pages\Http\Controllers\Backend\BaseController;
use Cms\Modules\Pages\Http\Requests\BackendUpdatePageRequest;
use Cms\Modules\Pages\Models\Content;
use Cms\Modules\Pages\Models\Page;
use Former\Facades\Former;

class PageUpdateController extends BaseController
{
    public function getForm(Page $page)
    {
        $this->editorAssets();
        $sections = config('cms.pages.editor.sections');

        $layouts = [];
        foreach (Theme::getLayouts() as $layout) {
            $layouts[$layout] = ['value' => $layout];
        }

        Former::populate($page);

        foreach ($sections as $section) {
            $section = strtolower($section);
            $content = $page->getSection($section);

            if ($content) {
                Former::populateField('editor_'.$section, $content->getOriginal('content'));
            }
        }

        return $this->setView('backend.page.form', compact('layouts', 'sections'));
    }

    public function postForm(Page $page, BackendUpdatePageRequest $request)
    {
        $input = $request->except('_token');

        $page->fill($request->only('title', 'slug', 'layout'));
        if ($page->isDirty()) {
            if ($page->save() !== true) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withError('Could not update main page details.');
            }
        }

        foreach (config('cms.pages.editor.sections') as $section) {
            $section = strtolower($section);
            $editor = 'editor_'.$section;

            if (!$request->has($editor)) {
                continue;
            }
            $content = $request->get($editor);

            $objSection = $page->content()->whereSection($section)->first();
            if ($objSection === null) {
                $objSection = new Content();
                $objSection->fill([
                    'page_id' => $page->id,
                    'page_id' => $page->id,
                    'author_id' => $request->user()->id,
                    'section' => $section,
                    'content' => $content,
                ]);
            }

            if (empty($content)) {
                $objSection->delete();
            } else {
                $objSection->content = $content;
                $save = $objSection->save();

                if ($save !== true) {
                    return redirect()
                        ->back()
                        ->withError('There was a problem saving one of the sections, please try again.');
                }
            }
        }

        return redirect(route('admin.pages.update', $page->id))
            ->withInfo('Page updated successfully.');
    }
}
