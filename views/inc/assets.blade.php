@if(intval(request()->server('SERVER_PORT')) !== 80)<script type="module" src="/.quasar/client-entry.js"></script>@else
@php $files = json_decode(@file_get_contents(public_path('assets.json')),true); @endphp
@foreach($files['css'] as $file)
<link rel="stylesheet" href="/assets/index.{{ $file }}.css">
@endforeach
@foreach($files['js'] as $file)
<script type="module" crossorigin src="/assets/index.{{ $file }}.js"></script>@endforeach
@endif

