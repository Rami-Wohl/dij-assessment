@component('mail::message')

Het wachtwoord om je bericht te ontsleutelen is {{ $decryptKey }}.

Groeten,<br>
{{ config('app.name') }}
@endcomponent
