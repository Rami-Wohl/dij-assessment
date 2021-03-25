@component('mail::message')

Iemand heeft je een versleuteld bericht verstuurd. Om deze te openen, klik op de onderstaande link.
Om het bericht te kunnen ontsleutelen heb je een wachtwoord nodig. Deze is in een aparte email
naar dit adres gestuurd.

@component('mail::button', ['url' => $messageUrl])
Ga naar bericht
@endcomponent

Groeten,<br>
{{ config('app.name') }}
@endcomponent
