@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

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
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
{{-- @lang('Regards'),<br>{{ config('app.name') }} --}}
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
@lang(
    // "หากคุณไม่สามารถกดปุ่ม \":actionText\" , กรุณาคัดลอกข้อความด้านล่างนี้ไปยังเว็บเบราว์เซอร์ของคุณ\n".
    // '[:actionURL](:actionURL)',
    // [
    //     'actionText' => $actionText,
    //     'actionURL' => $actionUrl,
    // ]
    "สอบถามข้อมูลเพิ่ม ติดต่อ กลุ่มงานถอนคืนรายได้ กองบริหารการรับจ่ายเงิน กรมบัญชีกลาง โทร.022177000 ต่อ ..."
)
@endcomponent
@endisset
@endcomponent
