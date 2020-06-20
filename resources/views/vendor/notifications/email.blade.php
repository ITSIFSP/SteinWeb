@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Olá!')
@endif
@endif

{{-- Intro Lines
@foreach ($introLines as $line)
{{ $line }}

@endforeach --}}
Você está recebendo esse email porque nós recebemos um solicitação de recuperação de senha da sua conta.
{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ 'Redefinir  Senha' }}
@endcomponent
@endisset

{{-- Outro Lines
@foreach ($outroLines as $line)
{{ $line }}

@endforeach --}}

Esse link para recuperação de senha irá expirar em 60 minutos.

Se você não solicitou uma recuperação de senha, nenhuma ação é necessária.

Atenciosamente,
Equipe ITS IFSP - Catanduva

{{-- Salutation
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif --}}

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "Se você estiver tendo problemas com o botão \"Redefinir Senha\", copie e cole o\n".
    'URL a baixo no seu navegador: [:displayableActionUrl](:actionURL)',
    [
        'actionText' => $actionText,
        'actionURL' => $actionUrl,
        'displayableActionUrl' => $displayableActionUrl,
    ]
)
@endslot
@endisset
@endcomponent
