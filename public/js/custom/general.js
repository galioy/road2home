//Google maps autosuggest and map global variables
var directionsDisplay = new google.maps.DirectionsRenderer();
var directionsService = new google.maps.DirectionsService();
var map;
var routeWaypoints = [];

$(function () {
    //Fix for closing modal on selecting item in a dropdown but
    var enforceModalFocusFn = $.fn.modal.Constructor.prototype.enforceFocus;


    $.fn.modal.Constructor.prototype.enforceFocus = function () {
    };

    $(".datepicker-registration").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        yearRange: "-50:-18"
    });

    var dateToday = new Date();
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        yearRange: "-00:+01",
        defaultDate: dateToday,
        minDate: dateToday
    });

    //Functions for showing and hiding the notice, for not being logged in in the trips_list page.
    $showNotice = function showNotLoggedInNotice(id) {
        if ($('.' + id + '.not-logged-in-notice').css('display') == 'none') {
            $('.' + id + '.not-logged-in-notice').fadeIn();
        }
    };

    $hideNotice = function showNotLoggedInNotice(id) {
        $('.' + id + '.not-logged-in-notice').fadeOut();
    };

    $showPopout = function showDisabledItemPopout() {
        if ($('.disabled-popout').css('display') == 'none') {
            $('.disabled-popout').fadeIn();
        }
    };

    $hidePopout = function showDisabledItemPopout() {
        $('.disabled-popout').fadeOut();
    };

    initializeGmaps(routeWaypoints);
});

function initializeGmaps(routeWaypoints) {

    if ($('#map').length > 0) {
        var horsens = new google.maps.LatLng(55.8546437, 9.838756);
        var mapOptions = {
            zoom: 12,
            center: horsens
        };
        map = new google.maps.Map(document.getElementById('map'), mapOptions);
        directionsDisplay.setMap(map);

        //Check if exisitng waypoints are defined. Used in edit_trip page
        var waypoints = $('.waypoint');

        if (waypoints.length > 0) {
            routeWaypoints = new Array();
            for (i = 0; i < waypoints.length; i++) {
                if (waypoints[i].value.length > 0) {
                    routeWaypoints.push({
                        location: waypoints[i].value,
                        stopover: true
                    });
                }

                //Autocomplete options
                var options = {
                    types: ['(cities)']
                };
                //Initialize autocomplete object and bind it ot the map
                var autocomplete = new google.maps.places.Autocomplete(waypoints[i], options);
                autocomplete.bindTo('bounds', map);
            }

        }

        //Initialize autocomplete object and bind it ot the map
        var autocompleteFrom = new google.maps.places.Autocomplete(document.getElementById('main_route_from_input'), options);
        var autocompleteTo = new google.maps.places.Autocomplete(document.getElementById('main_route_to_input'), options);
        autocompleteFrom.bindTo('bounds', map);
        autocompleteTo.bindTo('bounds', map);
    }
}

/**
 * Calculates a route, through the Gmaps API and shows it on the map
 */
function calcRoute() {
    var start = $('#main_route_from_input').val();
    var end = $('#main_route_to_input').val();
    var waypoints = $('.waypoint');

    if (waypoints.length > 0) {
        routeWaypoints = [];
        for (var i = 0; i < waypoints.length; i++) {
            if (waypoints[i].value.length > 0) {
                routeWaypoints.push({
                    location: waypoints[i].value,
                    stopover: true
                });
            }
        }
    }

    if (routeWaypoints.length > 0) {
        var request = {
            origin: start,
            waypoints: routeWaypoints,
            destination: end,
            travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            }
        });
    }
    else {
        var request = {
            origin: start,
            destination: end,
            travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            }
        });
    }
}

/**
 * Calculates the distance, in km, and the estimated duration of the journey between the start and end points
 * of the main route given, through the Gmaps API, and saves the two values in the form input fields in the
 * offer or edit trip page.
 */
function calculateDistance() {
    var startPoint = $('#main_route_from_input').val();
    var endPoint = $('#main_route_to_input').val();
    var distanceService = new google.maps.DistanceMatrixService();

    distanceService.getDistanceMatrix({
        origins: [startPoint],
        destinations: [endPoint],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
        avoidHighways: false,
        avoidTolls: false
    }, function (response, status) {
        if (status != google.maps.DistanceMatrixStatus.OK) {
            alert('Distance Matrix could not calculate distance. Status: ' + status);
        }
        var distance = response.rows[0].elements[0].distance.text;
        var duration = response.rows[0].elements[0].duration.text;

        $('#distance_label').text(distance);
        $('#duration_label').text(duration);
        $('#distance').val(distance);
        $('#duration').val(duration);
    });
}
