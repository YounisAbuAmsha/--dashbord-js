<x-mail::message>
# Ucas Website

Welcome UserName in Ucas Website.

<x-mail::panel>
The email is : -----
</x-mail::panel>

<x-mail::button :url="''">
Admin Panel
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

