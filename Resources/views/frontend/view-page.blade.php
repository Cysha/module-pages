
@set($content, array_get($page, 'content.view', null))

@if ($content !== null)
{!! $content->getOriginal('content') !!}
@endif

