<x-mail::message>

{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('auth.whoops')
@else
# @lang('auth.hello')
@endif
@endif

{{-- Intro Lines --}}
{{-- @foreach ($introLines as $line)
{{ $line }}
@endforeach --}}
@lang('password.password_reset_request')

{{-- Action Button --}}
@isset($actionText)
<?php
  $color = match ($level) {
    'success', 'error' => $level,
    default => 'primary',
  };
?>
<x-mail::button :url="$actionUrl" :color="$color">
  @lang('password.reset_password')
</x-mail::button>
@endisset

{{-- Outro Lines --}}
{{-- @foreach ($outroLines as $line)
{{ $line }}
@endforeach --}}
<p>@lang('password.reset_link_expiration')</p>
<p>@lang('password.no_action_required')</p>

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('auth.regards')<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
  'password.trouble_clicking_button',
  [
    'actionText' => $actionText,
  ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
