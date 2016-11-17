{{ HTML::style('css/bootstrap.css') }}
{{ HTML::style('css/Styles.css') }}
{{ HTML::style('css/Img_overlay.css') }}
{{ HTML::style('css/animate.css') }}
{{ HTML::style('css/external/jquery-ui.min.css') }}
{{ HTML::style('css/external/jquery-ui.structure.min.css') }}
{{ HTML::style('css/external/jquery-ui.theme.css') }}
{{ HTML::style('css/external/parsley.css') }}
{{ HTML::style('css/font-awesome.css') }}
{{ HTML::style('css/bootstrap-social.css') }}


@foreach(scandir('css/external') as $path)
    @if($path != '.' && $path!='..')
        {{ HTML::style('css/external/'.$path) }}
    @endif
@endforeach
