@component('mail::message')
# Introduction

Blood Bank reset password
<p>Hello{{$user->name}}</p>
<P>your reset code is :{{$user->pin_code}}</p>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
