{{--
 * Author: Galin Kostov
 * Date: 2/23/15
--}}
@extends('shared.master_layout')
@section('content')
    <div class="row padding-top-10 padding-bottom-10">
        {{-- Driver Profile information --}}
        <div class="col-md-offset-1 col-md-2 no-side-padding">
            <div class="row">
                <h3>Your driver:</h3>
            </div>
            <div class="row">
                <img src="../images/profile-pic.png" class="img-circle profile-picture-big">
            </div>
            <div class="row">
                <h2>Keremidko Tuhlov</h2>
            </div>
            <div class="row padding-bottom-10">
                (21 years old)
            </div>
            <div class="row padding-bottom-10">
                <img src="../images/icons/no_smoking.png" class="img-circle small-icon">
                <img src="../images/icons/music.png" class="img-circle small-icon">
            </div>
            <div class="row padding-bottom-10">
                <span id="uni-label" class="inline-block">University:</span>
                <span id="university" class="inline-block">VIA University College</span>
            </div>
            <div class="row padding-bottom-10">
                Some more info <br>
                Some more info <br>
                Some more info <br>
                Some more info <br>
                Some more info <br>
            </div>
            <div class="row">
                <h3>His/her car:</h3>
            </div>
            <div class="row padding-bottom-10">
                <img src="../images/car.jpg" class="img-circle car-picture-trip">
            </div>
            <div class="row padding-bottom-10">
                Ford Mustang GT
            </div>
            <div class="row padding-bottom-10">
                Year: 1987
            </div>
        </div>

        {{-- Trip information --}}
        <div class="col-md-5">
            <div class="row padding-bottom-10 margin-bottom-10">
                <h1>Aarhus -> Copenhagen</h1>
            </div>
            <div class="row top-border-1 bottom-border-1 margin-bottom-10">
                <div class="col-md-1 repeating-days-width no-side-padding text-center side-borders-1 background-color-red">
                    <h3>Mo</h3>
                </div>
                <div class="col-md-1 repeating-days-width no-side-padding text-center right-border-1">
                    <h3>Tue</h3>
                </div>
                <div class="col-md-1 repeating-days-width no-side-padding text-center right-border-1">
                    <h3>Wed</h3>
                </div>
                <div class="col-md-1 repeating-days-width no-side-padding text-center right-border-1 background-color-red">
                    <h3>Thu</h3>
                </div>
                <div class="col-md-1 repeating-days-width no-side-padding text-center right-border-1">
                    <h3>Fri</h3>
                </div>
                <div class="col-md-1 repeating-days-width no-side-padding text-center right-border-1 background-color-red">
                    <h3>Sat</h3>
                </div>
                <div class="col-md-1 repeating-days-width no-side-padding text-center right-border-1 background-color-red">
                    <h3>Sun</h3>
                </div>
            </div>
            <div class="row padding-top-10 bottom-border-1">
                <div class="col-sm-3 col-sm-offset-2">
                    <h3>Price:</h3>
                </div>
                <div class="col-sm-2 col-sm-offset-1">
                    <h4>30 DKK</h4>
                </div>
            </div>
            <div class="row padding-top-10 bottom-border-1">
                <div class="col-sm-3 col-sm-offset-2">
                    <h3>Luggage:</h3>
                </div>
                <div class="col-sm-4 col-sm-offset-1">
                    <h4>Small - eg. backpack</h4>
                </div>
            </div>
            <div class="row padding-top-10 bottom-border-1">
                <div class="col-sm-3 col-sm-offset-2">
                    <h3>Preferences:</h3>
                </div>
                <div class="col-sm-4 col-sm-offset-1">
                    <img src="../images/icons/no_smoking.png" class="img-circle small-icon">
                    <img src="../images/icons/music.png" class="img-circle small-icon">
                    <img src="../images/icons/no_pets_allowed.png" class="img-circle small-icon">
                    <img src="../images/icons/no_food_allowed.png" class="img-circle small-icon">
                </div>
            </div>
            <div class="row padding-top-10 bottom-border-1">
                <div class="col-sm-3 col-sm-offset-2">
                    <h3>Comments:</h3>
                </div>
                <div class="col-sm-4 col-sm-offset-1">
                    <h4>This gunna be da moust epic ride o' yo' life!</h4>
                </div>
            </div>
            <div class="row padding-top-10 text-center">
                <div class="col-lg-12">
                    <img src="../images/map.png" class="img-rounded resize-fit-element-100p">
                </div>
            </div>
        </div>

        {{-- Trip controls --}}
        <div class="col-md-2 padding-top-10">
            <div class="row padding-bottom-10 padding-top-10">
                {{ Form::submit('Get on the ride!', [
                                    'id' => 'sign-for-trip-button',
                                    'class' => 'btn btn-lg btn-success button-width-250']) }}
            </div>
            <div class="row padding-bottom-10">
                <img src="../images/icons/taken_space_man.png" class="img-rounded small-icon">
                <img src="../images/icons/taken_space_man.png" class="img-rounded small-icon">
                <img src="../images/icons/taken_space_man.png" class="img-rounded small-icon">
                <img src="../images/icons/free_space_man.png" class="img-rounded small-icon">
            </div>
            <div class="row empty-div-height-100"></div>
            {{--@if(has parent trip)--}}
            <div class="row padding-bottom-10">
                {{ Form::submit('This is a partial trip of...', [
                                    'class' => 'btn btn-lg btn-default button-width-250']) }}
            </div>
            {{--@endif--}}
            {{--@if(is round trip)--}}
            <div class="row">
                {{ Form::submit('Round trip?', ['class' => 'btn btn-lg btn-default button-width-250']) }}
            </div>
            {{--@endif--}}
        </div>
    </div>
@stop