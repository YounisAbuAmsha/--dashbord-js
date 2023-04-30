<x-mail::message>
# Ucas Website

Welcome {{$user->name}} in Ucas Website.

<x-mail::panel>
The email is : {{$user->email}}
</x-mail::panel>

<x-mail::button :url="'http://127.0.0.1:8000/cms/admin/login'">
Admin Panel
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

