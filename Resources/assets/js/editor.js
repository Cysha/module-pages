var cm_settings = {
    view: { mode: 'text/html', profile: 'xhtml' },
    php: { mode: 'text/x-php' },
    css: { mode: 'text/css' },
    js: { mode: 'text/javascript' },
    keywords: { mode: 'text' },
    description: { mode: 'text' }
};

jQuery(function () {
    // spawn new instances of the editor
    jQuery('textarea[data-codemirror]').each(function (i, ele) {
        $this = jQuery(ele);
        id = $this.attr('id');
        section = id.replace('editor_', '');

        codemirror('textarea#'+id, (cm_settings[section] || {}));
    });

    // everytime we switch tab, refresh the CM ui
    jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        jQuery('.tab-pane:visible textarea[data-codemirror]').each(function (i, ele) {
            jQuery(ele).data('CodeMirrorInstance').refresh();
        });
    });
});

function codemirror(element, options)
{
    $options = jQuery.extend(cm_defaults, options);
    instance = CodeMirror.fromTextArea(jQuery(element)[0], $options);
    instance.on('change', function (cm, change) {
        textarea_id = jQuery(element).attr('id');
        textarea_id = textarea_id.replace('editor_', '');

        link = jQuery('a[href="#'+textarea_id+'"]');
        link_text = link.text();
        link_length = parseInt(link_text.length);

        if (link_text.substring(link_length-1) != '*') {
            link.text(link_text+'*');
        }
    });

    jQuery(element).data('CodeMirrorInstance', instance);

    return instance;
}