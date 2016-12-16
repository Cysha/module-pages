{!! Former::horizontal_open() !!}
<div class="row">
    <div class="col-md-12">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#settings" data-toggle="tab">Page Settings</a></li>
                    @forelse($sections as $section)
                    <li>
                        <a href="#{{ strtolower($section) }}" data-toggle="tab">Editor - {{ $section }}</a>
                    </li>
                    @empty
                    @endforelse
                    <li class="pull-right">
                        <button class="btn-labeled btn btn-success btn-sm pull-right" type="submit">
                            <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span> Save Page
                        </button>
                    </li>
                </ul>
            </div>
            <div class="panel-body panel-code">
                <div class="tab-content">
                    <div class="tab-pane active fade in" id="settings">
                        <div class="col-md-9">
                            {!! Former::text('title') !!}
                            {!! Former::text('slug')->prepend(str_replace(request()->path(), '', request()->url())) !!}
                            {!! Former::select('layout')->options($layouts)->label('Page Layout')->noKeys() !!}
                            {!! Former::radio('active')
                                ->radios([
                                    'Yes' => ['value' => 'true'],
                                    'No' => ['value' => 'false']
                                ])
                                ->label('Page Active?')
                                ->inline()
                            !!}
                        </div>
                    </div>

                    {!! Former::framework('Nude') !!}
                    @forelse($sections as $section)
                    @set($section, strtolower($section))
                    <div class="tab-pane fade" id="{{ $section }}">
                        {!! Former::textarea('editor_'.$section)->label(false)->data_codemirror('true') !!}
                    </div>
                    @empty
                    @endforelse
                    {!! Former::framework('TwitterBootstrap3') !!}

                </div>
            </div>
        </div>
    </div>
</div>

{!! Former::close() !!}
