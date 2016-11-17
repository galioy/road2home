<div id="search-bar-container"
     class="row padding-top-10 padding-bottom-10  {{ Route::current()->getName() == 'home' ? 'display-none' : '' }}"
     style="padding-top:11px">
    <div class="col-md-12 no-side-padding text-center">
        {{ Form::open(['route' => 'search.trips', 'method' => 'get', 'data-parsley-validate']) }}
        <div class="col-md-offset-2 col-md-9 no-side-padding">
            <div class="col-md-offset-1 col-md-3">
                {{ Form::text('search_route_from', null, ['class' => 'form-control route-from-field',
                  'id'=>'autocompleteTopBarFrom',
                  'placeholder' => 'From',
                  'data-parsley-required' => 'true'])}}
            </div>
            <div class="col-md-3">
                {{ Form::text('search_route_to', null, ['class' => 'form-control route-to-field',
                  'id'=>'autocompleteTopBarTo',
                  'placeholder' => 'To',
                  'data-parsley-required' => 'true']) }}
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon calendar-icon"></span></span>
                    {{ Form::text('date', null, ['class'=>'form-control edit-years-input datepicker date-field']) }}
                </div>
            </div>
            <div class="col-md-1 no-side-padding">
                {{ Form::submit('Search!', ['class' => 'form-control btn-success']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
