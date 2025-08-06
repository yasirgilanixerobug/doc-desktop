
@props(['type', 'title', 'body', 'footer'])

<div class="alert alert-{{ $type }}" role="alert">
    <h4 class="alert-heading">{{ $title }}</h4>
    <p>{!! $body !!}</p>
    <hr>
    <p class="mb-0">{{ $footer }}</p>
</div>
