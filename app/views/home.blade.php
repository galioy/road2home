@extends('shared.master_layout')

@section('content')
    <div id="home-background" class="full-screen">
    </div>
    <div class="home-splash-content">
        <div class="home-greeting-message">
            <h1 class="greeting-text animated fadeIn">Find your way home</h1>
        </div>
        <div class="home-search-container col-md-12 no-side-padding text-center">
            {{ Form::open(['route' => 'search.trips', 'method' => 'get', 'data-parsley-validate']) }}
                <div class="col-md-offset-1 col-md-3 no-side-padding">
                    {{ Form::text('search_route_from', null, [ 'id'=>'autocompleteFrom',
                            'class' => 'form-control',
                            'placeholder' => 'From',
                            'data-parsley-required' => 'true']) }}
                </div>
                <div class="col-md-3 no-side-padding">
                    {{ Form::text('search_route_to', null, ['id'=>'autocompleteTo',
                            'class' => 'form-control',
                            'placeholder' => 'To',
                            'data-parsley-required' => 'true']) }}
                </div>
                <div class="col-md-2 no-side-padding">
                  <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon calendar-icon"></span></span>
                    {{ Form::text('date', null, ['id' => 'home-search-date-field', 'class'=>'form-control edit-years-input datepicker date-field']) }}
                  </div>
                </div>
                <div class="col-md-1 no-side-padding">
                    {{ Form::submit('Search!', ['id' => 'home-search-button', 'class' => 'form-control btn-success']) }}
                </div>
            {{ Form::close() }}
        </div>
    </div>
    <div class="home-statistics-container">
        <div class="col-sm-3 text-center height-100">
            <h2>
                @if(isset($statistics->km_traveled))
                  {{ $statistics->km_traveled }}
                @else
                  0
                @endif
                <small>km travelled</small>
            </h2>
        </div>
        <div class="col-sm-3 text-center height-100">
            <h2>
                @if(isset($statistics->co_saved))
                  {{ $statistics->co_saved }}
                @else
                  0
                @endif
                <small>kg of CO2 saved</small>
            </h2>
        </div>
        <div class="col-sm-3 text-center height-100">
            <h2>
                @if(isset($statistics->trips_taken))
                  {{ $statistics->trips_taken }}
                @else
                  0
                @endif
                <small>trips taken</small>
            </h2>
        </div>
        <div class="col-sm-3 text-center height-100">
            <h2>
                @if(isset($statistics->passengers_driven) && isset($statistics->trips_taken))
                  {{ $statistics->passengers_driven + $statistics->trips_taken }}
                @else
                  0
                @endif
                <small>people traveled</small>
            </h2>
        </div>
    </div>
    <div class="home-current-trips-container height-50">
       <div class="trips-teaser-container">
           <img class="loading-gif" src="../images/ajax-loader.gif">
       </div>
    </div>
    {{--Google maps autosuggest--}}
    <script type="text/javascript">
        function initialize() {
            //Autocomplete options
            var options = {
                types: ['(cities)']
            };
            //Initialize autocomplete object and bind it ot the map
            var autocompleteFrom = new google.maps.places.Autocomplete(document.getElementById('autocompleteFrom'), options);
            var autocompleteTo = new google.maps.places.Autocomplete(document.getElementById('autocompleteTo'), options);
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    {{ HTML::script('js/custom/homepage_teaser.js') }}
@stop
