$(document).ready(function () {
    calcRoute();

    /* First, hide the contents of the tabs, except the 1st one */
    $('#tab-content-2').hide();
    $('#tab-content-3').hide();
    $('#tab-content-4').hide();

    /* Max number of stops allowed is 3 */
    window.stops_count = 0;
    /* A list of already used random ids */
    window.random_ids = [];

    /* 'backend.partial_trips' is passed from PHP directly to JavaScript */
    if (backend.partial_trips) {
        /* An array to hold the stops values (the routes) */
        window.stops_array = backend.partial_trips;
        window.stops_array.forEach(function (item, index) {
            addStopField(stops_count, random_ids, item.route_to + ',' + item.country_to)
        });
    } else {
        window.stops_array = [];
    }

    $('#stop_add_btn').bind('click', function (e) {
        e.preventDefault();
        addStopField(stops_count, random_ids, '');
    });

    /* Bind the Next and Back buttons actions */
    $('.stepform').on('submit', function (e) {
        e.preventDefault();
        nextTab();
    });
    $('.prevBtn').bind('click', prevTab);

    var dateToday = new Date();
    var start_date = $('#datepicker-start_date');
    start_date.datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        yearRange: '-00:+01',
        minDate: dateToday,
        onSelect: function (selected) {
            $('#datepicker-arrival_date').datepicker('option', 'minDate', selected)
        }
    });

    $('#offer_trip_form').on('submit', function () {
        cutPasteValuesToHiddenFields();
        return true;
    });
});

function getSelectedTabIndex(step) {
    var activeTab = $('.active-tab');
    var activeTabId = activeTab[0].id;
    var selected = parseInt(activeTabId.substr(activeTabId.length - 1)) + step;
    var tabsCount = $('#tabs-content >ul >li').size();
    var lastTab = false;

    if (selected == 1) {
        $('#prevBtn').hide();
    }
    else {
        $('#prevBtn').show();
    }

    /* If 2nd tab - add the values (routes) from the stops inputs to the list of stops */
    if (selected == 2) {
        addStopValues(stops_array);
        calculateDistance();
    }

    if (selected == tabsCount) {
        $('#nextBtn').hide();
        lastTab = true;
    }
    else {
        $('#nextBtn').show();
    }

    if (lastTab) {
        /* If last tab - clear the stops content div and populate it with
         * generated the labels and price input fields for stops routes
         */
        $('#stops_labels_prices_content').empty();
        addStopLabelsAndPrices(stops_array);
        $('#finishBtn').show();
    }
    else {
        $('#finishBtn').hide();
    }

    return selected;
}

/**
 * Shows the next tab of the currently selected one and hides the current one.
 */
function nextTab() {
    var newTabIndex = parseInt(getSelectedTabIndex(1));

    $('#tab-content-' + (newTabIndex - 1)).hide();
    $('#tab-content-' + newTabIndex).show();
    $('#tab-' + (newTabIndex - 1)).removeClass('active-tab');
    $('#tab-' + newTabIndex).addClass('active-tab');
}

/**
 * Shows the previous tab of the currently selected one and hides the current one.
 */
function prevTab() {
    var newTabIndex = parseInt(getSelectedTabIndex(-1));
    $('#tab-content-' + (newTabIndex + 1)).hide();
    $('#tab-content-' + newTabIndex).show();
    $('#tab-' + (newTabIndex + 1)).removeClass('active-tab');
    $('#tab-' + newTabIndex).addClass('active-tab');
}

/**
 * Adds a stop input field to the tab contents.
 * Binds it to the Gmaps route calculation map
 * @param {int} stops_count
 * @param {[]} random_ids
 * @param {string} route
 */
function addStopField(stops_count, random_ids, route) {
    if (route.length == 0) {
        if (stops_count > 2) {
            return;
        }
    }

    var random_id = getRandomInt(1, 100, random_ids);
    random_ids.push(random_id);

    /* Add the stop input field */
    $('#stops_content').append(getAddStopFieldHTML(random_id, route));

    //Autocomplete options
    var options = {
        types: ['(cities)']
    };
    /*
     * Initialize autocomplete object and bind it ot the map
     * Add the route to the Gmaps view
     */
    var autocomplete = new google.maps.places.Autocomplete(document.getElementById('stop_input_' + random_id), options);
    autocomplete.bindTo('bounds', map);

    /* Bind the close button (x) for the stop field to its function */
    $('#stop_close_btn_' + random_id).bind('click', function (e) {
        e.preventDefault();
        $('#stop_row_' + random_id).remove();
        window.stops_count--;
        if (window.stops_count < 3) {
            $('#stop_add_btn').show();
        }
    });

    /* Increment the number of allowed stop fields left and hide the add button if no allowed fields left */
    window.stops_count++;
    if (window.stops_count == 3) {
        $('#stop_add_btn').hide();
    }
}

/**
 * Add a route value to the array of stops.
 *
 * @param {[]} stops_array
 */
function addStopValues(stops_array) {
    stops_array.length = 0;
    $('.stop_input').each(function () {
        var route = $(this).val();
        if (route.length != 0) {
            stops_array.push(route);
        }
    });
}

function addStopLabelsAndPrices(stops_array) {
    $('#main_route_label').text($('#main_route_from_input').val() + ' > ' + $('#main_route_to_input').val());
    stops_array.forEach(function (item, index) {
        var route = $('#main_route_from_input').val() + ' > ' + item;
        console.log(item);
        $('#stops_labels_prices_content').append(getAddStopLabelAndPriceFieldHTML(index, route));
        $('#offer_trip_form').append(getStopRouteHTML(index, item));
    })
}

/**
 * Simply returns a ready HTML string, that is the stop input field, whereas only gives the provided ID count,
 * so the field is distinguishable from the other 2 stop input fields.
 *
 * @param {int} count
 * @param {string} route
 * @returns {string}
 */
function getAddStopFieldHTML(count, route) {
    var row_id = 'stop_row_' + count;
    var input_field_id = 'stop_input_' + count;
    var close_btn_id = 'stop_close_btn_' + count;

    return "<div id='" + row_id + "' class='row form-group'>" +
        "<div class='col-sm-3 text-right no-side-padding'>" +
        "<label for='from_label'>Via</label>" +
        "</div>" +
        "<div class='col-sm-8 text-left'>" +
        "<input id='" + input_field_id + "' class='form-control waypoint stop_input'" +
        "onblur='calcRoute()'" +
        "data-parsley-required='true'" +
        "data-parsley-trigger='keyup'" +
        "data-parsley-validation-threshold = '0' name='stop_route_" + count + "_dum' type='text' value='" + route + "'>" +
        "</div>" +
        "<div class='col-sm-1 text-left no-side-padding'>" +
        "<a href='#' id='" + close_btn_id + "'>" +
        "<b>x</b>" +
        "</a>" +
        "</div>" +
        "</div>";
}

function getAddStopLabelAndPriceFieldHTML(count, route) {
    var row_id = 'stop_price_row_' + count;
    var label_id = 'stop_label_' + count;
    var price_input_id = 'stop_price_input_' + count;

    return "<div id='" + row_id + "' class='row form-group'>" +
        "<div id='" + label_id + "' class='col-sm-offset-1 col-sm-7 text-left no-side-padding'>" +
        route +
        "</div>" +
        "<div class='col-sm-3 text-right no-side-padding'>" +
        "<input id='" + price_input_id + "' class='form-control trip_price_input_width'" +
        "data-parsley-trigger='keyup'" +
        "data-parsley-required='true'" +
        "data-parsley-type='integer'" +
        "data-parsley-validation-threshold='0'" +
        "data-parsley-min='1'" +
        "data-parsley-minlength='1' name='stop_price_" + count + "' type='text'>" +
        "</div>" +
        "</div>";
}

function getStopRouteHTML(count, route) {
    return "<input type='hidden' name='stop_route_" + count + "' value='" + route + "'>";
}

function cutPasteValuesToHiddenFields() {
    $("[name='trip_type']").val($("[name='trip_type_dum']").val());
    $("[name='route_from']").val($("[name='route_from_dum']").val());
    $("[name='route_to']").val($("[name='route_to_dum']").val());
    $("[name='start_date']").val($("[name='start_date_dum']").val());
    $("[name='start_hour']").val($("[name='start_hour_dum']").val());
    $("[name='start_minutes']").val($("[name='start_minutes_dum']").val());
    $("[name='arrival_date']").val($("[name='arrival_date_dum']").val());
    $("[name='arrival_hour']").val($("[name='arrival_hour_dum']").val());
    $("[name='arrival_minutes']").val($("[name='arrival_minutes_dum']").val());
    $("[name='seats']").val($("[name='seats_dum']").val());
    $("[name='luggage']").val($("[name='luggage_dum']").val());
    $("[name='additional_info']").val($("[name='additional_info_dum']").val());
    $('input[type=checkbox]').each(function () {
        if ($(this).is(':checked')) {
            $('#offer_trip_form').append("<input name='" + $(this).attr('name') + "' type='hidden'>");
        }
    });
}

/**
 * Returns a random integer between min (included) and max (excluded) that hasn't been generated already.
 * Using Math.round() will give non-uniform distribution!
 */
function getRandomInt(min, max, random_ids) {
    var random_id = Math.floor(Math.random() * (max - min)) + min;
    if (random_ids.indexOf(random_id) > 0) {
        return getRandomInt(min, max, random_ids);
    } else {
        return random_id;
    }
}