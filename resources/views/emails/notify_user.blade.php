<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EMS notification</title>
</head>
<body>
<div>
    @component('mail::message')
        <p>{{ $message }}</p>
        @if($data)
            @foreach($data as $row)
                <p style="padding-left: 20px;">{{ $row }}</p>
            @endforeach
        @endif
    @endcomponent
</div>
</body>
</html>
