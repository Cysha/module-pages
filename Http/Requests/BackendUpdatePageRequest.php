<?php

namespace Cms\Modules\Pages\Http\Requests;

use Auth;
use Cms\Http\Requests\Request;
use Cms\Modules\Core\Models\Theme;
use Illuminate\Validation\Rule;

class BackendUpdatePageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && hasPermission('update@pages_backend');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $tblPrefix = config('cms.pages.table-prefix', 'pages_');
        $layouts = Theme::getLayouts();
        $sections = config('cms.pages.editor.sections', []);
        $pageId = request()->segment(3);

        $rules = [
            'title' => 'required|string',
            'slug' => ['required', 'string', Rule::unique($tblPrefix.'pages')->ignore($pageId, 'id')],
            'layout' => 'required|string|in:'.implode(',', $layouts),
        ];

        foreach ($sections as $section) {
            $section = strtolower($section);
            $rules['editor_'.$section] = 'present|string';
        }

        return $rules;
    }
}
