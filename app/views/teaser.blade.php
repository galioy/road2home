@if(isset($trips))
    <ul class="teasers-list">
        @foreach($trips as $trip)
            <li class="teaser-element">
                <div class="col-md-3">
                    <img id="profile-picture-big"
                         src="{{ asset(HTML::ProfilePicPath($trip->driver['email'], $trip->driver['gender'])) }}"
                         class="img-circle">
                </div>
                <div class="col-md-6">
                    <div class="col-md-6 trip-list-route">
                        <p class="city_route inline-block"> {{ $trip->route_from }}</p>,
                        <p class="text-minified inline-block">{{ $trip->country_from }}</p>
                        <br>to <p class="city_route inline-block"> {{ $trip->route_to }}</p>,
                        <p class="text-minified inline-block">{{ $trip->country_to }}</p>
                    </div>
                    <div class="col-md-6 text-right trip-time">
                        <b>{{ date('d M Y', strtotime($trip->start_date)) }}</b>
                        <i>at</i>
                        <b>{{ date('G:i', strtotime($trip->start_date)) }}</b>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-6">
                        Driver:
                        {{ HTML::linkRoute('account.show',
                                    $trip->driver['name'] . ' ' . $trip->driver['surname'],
                                    $trip->driver['id']) }}
                    </div>
                    <div class="col-md-6 text-right">
                        {{ HTML::linkRoute('trips.show', 'Check it out!', $trip->id,
                        ['class' => 'btn btn-success']) }}
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <ul class="teasers-list">
        <h1 class="no-trips-message">Oops, no trips going on... :\</h1>
    </ul>
@endif

