<?php

namespace Cms\Modules\Pages\Http\Controllers\Backend;

use Cms\Modules\Core\Http\Controllers\BaseBackendController;

class BaseController extends BaseBackendController
{
    public function boot()
    {
        parent::boot();

        $this->theme->setTitle('pages');
    }

    public function editorAssets()
    {
        $basePath = 'modules/pages/codemirror/';

        $this->theme->asset()->add('panel-tabs-css', 'modules/pages/css/panel-tabs.css', ['css']);

        $this->theme->asset()->add('codemirror-css', $basePath.'css/codemirror.css');
        $this->theme->asset()->add('codemirror-js', $basePath.'js/codemirror.js');

        $assets = [
            'codemirror-mode-xml' => 'js/mode/xml/xml.js',
            'codemirror-mode-htmlmixed' => 'js/mode/htmlmixed/htmlmixed.js',
            'codemirror-mode-php' => 'js/mode/php/php.js',
            'codemirror-mode-js' => 'js/mode/javascript/javascript.js',
            'codemirror-mode-css' => 'js/mode/css/css.js',
            'codemirror-mode-clike' => 'js/mode/clike/clike.js',
            'codemirror-keymap-sublime' => 'js/keymap/sublime.js',
            'codemirror-addon-searchcursor' => 'js/addon/search/searchcursor.js',
            'codemirror-addon-overlay' => 'js/addon/mode/overlay.js',
            'codemirror-addon-active-line' => 'js/addon/selection/active-line.js',
            'codemirror-addon-emmet' => 'js/addon/emmet/emmet.js',
        ];

        if (($theme = config('cms.pages.editor.theme', null)) !== null) {
            $assets['codemirror-theme'] = sprintf('css/themes/%s.css', $theme);
        }

        // make sure we register the assets
        foreach ($assets as $key => $value) {
            $this->theme->asset()->add($key, $basePath.$value, ['codemirror-js']);
        }

        // codemirror config
        $jsarray = [
            'continuousScanning' => 500,
            'gutter' => true,
            'lineNumbers' => true,
            'keyMap' => 'sublime',
            'autoCloseBrackets' => true,
            'matchBrackets' => true,
            'showCursorWhenSelecting' => true,
            'indentUnit' => config('cms.pages.editor.indent', 4),
            'styleActiveLine' => true,
        ];

        if (($theme = config('cms.pages.editor.theme', null)) !== null) {
            $jsarray['theme'] = $theme;
        }

        // do some dodgy inline stuffs
        $this->theme->asset()->writeScript(
            'pages-editor-js',
            'var cm_defaults = '.json_encode($jsarray).';',
            ['codemirror-js']
        );
        $this->theme->asset()->add('pages-editor-basejs', 'modules/pages/js/editor.js', ['pages-editor-js']);
        $this->theme->asset()->writeStyle(
            'pages-editor-css',
            '.CodeMirror {
                border: 1px solid #eee;
                height: auto;
            }
            .tab-pane .col-md-12 .CodeMirror{
                min-height: 500px;
            }
            .CodeMirror-scroll {
                overflow-y: hidden;
                overflow-x: auto;
            }',
            ['codemirror-theme']
        );
    }
}
