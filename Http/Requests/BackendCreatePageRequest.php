<?php

namespace Cms\Modules\Pages\Http\Requests;

use Auth;
use Cms\Http\Requests\Request;
use Cms\Modules\Core\Models\Theme;

class BackendCreatePageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && hasPermission('create@pages_backend');
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

        return [
            'title' => 'required',
            'slug' => ['required', 'string', Rule::unique($tblPrefix.'pages')],
            'layout' => 'required|string|in:'.implode(',', $layouts),
            'active' => 'required|boolean',
        ];
    }
}
