<!DOCTYPE html>
<html>
<head><title>Eleoi Home</title>
    <meta charset=utf-8>
    <meta name=description content="A Quasar Project">
    <meta name=format-detection content="telephone=no">
    <meta name=msapplication-tap-highlight content=no>
    <meta name=viewport content="user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1,width=device-width">
    <link rel=icon type=image/png sizes=128x128 href="/icons/favicon-128x128.png">
    <link rel=icon type=image/png sizes=96x96 href="/icons/favicon-96x96.png">
    <link rel=icon type=image/png sizes=32x32 href="/icons/favicon-32x32.png">
    <link rel=icon type=image/png sizes=16x16 href="/icons/favicon-16x16.png">
    <link rel=icon type=image/ico href="/favicon.ico">
    @forelse(\Illuminate\Support\Facades\DB::table('_masters')->pluck('id') as $master)
    <script type="text/javascript" src="{!! route('master_asset_js',master_asset_js_route_params($master)) !!}"></script>
    @empty
        <!-- I AM EMPTY -->
    @endforelse
</head>
<body>
<div id=q-app></div>
@include('Eleoi::inc.assets')
</body>
</html>
