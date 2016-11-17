<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Road2Home</title>
    {{--<link rel="shortcut icon" href="{{ URL::to('favicon.ico') }}">--}}
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    @include('styles')
  @include('scripts')
  <!--[if !IE 7]>
    <style type="text/css">
        #wrap {
            display: table;
            height: 100%
        }
    </style>
    <![endif]-->
</head>
<body>
{{--Header including navigation--}}
@include('shared.header')
{{--Trips search bar--}}
@include('shared.search_bar')
<div id="wrap">
    <div id="main">
        {{--Main Content--}}
        @yield('content')
    </div>
</div>
<div id="footer">
    {{--Footer including Contact info,Unis and Social network links --}}
    @include('shared.footer')
</div>
@if(!(Request::path() === '/'))
    <script type="text/javascript">
        function initialize() {
            //Autocomplete options
            var options = {
                types: ['(cities)']
            };
            //Initialize autocomplete object and bind it ot the map
            var autocompleteFrom = new google.maps.places.Autocomplete(document.getElementById('autocompleteTopBarFrom'), options);
            var autocompleteTo = new google.maps.places.Autocomplete(document.getElementById('autocompleteTopBarTo'), options);
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    @endif
            <!--Start Cookie Script-->
    <script type="text/javascript" charset="UTF-8"
            src="http://chs03.cookie-script.com/s/0b9f37dbb9b0bd65902bc2effee96738.js">
    </script>
    <!--End Cookie Script-->

</body>
</html>
