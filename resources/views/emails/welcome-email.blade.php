@component('mail::message')
# Welcome to freeCodeGram

This is a comunity of fellow developers and we are happy that you have joined us.

All the best,<br>
{{ config('app.name') }}
@component('mail::button', ['url' => ''])
    Button Text
@endcomponent

@endcomponent
