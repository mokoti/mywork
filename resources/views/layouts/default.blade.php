<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metadata->description }}">
    <meta name="keywords" content="{{ implode(', ' , $metadata->keywords) }}">
    <meta name="author" content="{{ $metadata->author }}">

    <title>{{ $metadata->page_title }}</title>

    <link rel='stylesheet' href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <style>
@section ('inline-style')
    footer{
        margin-bottom: 5em;
    }
@show
    </style>

    <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}" defer="defer"></script>
</head>

<body>

@yield ('content')

@include ('partials.footer')

    <script>
@section ('inline-script')
@show
    </script>

</body>
</html>

