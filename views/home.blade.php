@php $origin = request()->server('REQUEST_SCHEME') . "://" . request()->server('HTTP_HOST') @endphp<!DOCTYPE html>
<html>
<head><title>Eleoi Home</title>
    <meta charset=utf-8>
    <meta name=description content="A Quasar Project">
    <meta name=format-detection content="telephone=no">
    <meta name=msapplication-tap-highlight content=no>
    <meta name=viewport content="user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1,width=device-width">
    <link rel=icon type=image/png sizes=128x128 href="{!! $origin !!}/icons/favicon-128x128.png">
    <link rel=icon type=image/png sizes=96x96 href="{!! $origin !!}/icons/favicon-96x96.png">
    <link rel=icon type=image/png sizes=32x32 href="{!! $origin !!}/icons/favicon-32x32.png">
    <link rel=icon type=image/png sizes=16x16 href="{!! $origin !!}/icons/favicon-16x16.png">
    <link rel=icon type=image/ico href="{!! $origin !!}/favicon.ico">
    <script type="text/javascript" src="{!! $origin !!}/init.js"></script>
    <style> html:root { @foreach(eleoi_config('brand_colors') as $brand => $color) --q-{{ $brand }}:{{ $color }};@endforeach } </style>
</head>
<body>
<div id=q-app></div>
@include('Eleoi::inc.assets')
</body>
</html>
