<div id="header-container" class="row header">
    <div class="col-md-1 text-center no-side-padding">
        <img class="logo" src="/images/logo.png">
    </div>
    <div class="col-md-2 text-left no-side-padding">
        <img class="logo-text" src="/images/logo-text.png">
    </div>
    <div class="site_navigation col-md-offset-1 col-md-3">
        <ul class="nav navbar-nav navbar-left top-navigation">
            <li>
                {{ HTML::linkRoute('home', 'Home') }}
            </li>
            <li>
                {{ HTML::link('trips', 'Trips') }}
            </li>
            @if(Auth::check())
                <li>
                    @if(Auth::user()->active)
                        {{ HTML::linkRoute('trips.create', 'Offer trip') }}
                    @else
                        {{--<div class="disabled-btn inline-block" onmouseover="$showPopout()" onmouseout="$hidePopout()">--}}
                        {{--                        {{ HTML::link('trips', 'Trips', ['class' => 'disabled-link']) }}--}}
                        <div style="margin-top: 4px" class="padding-15 disabled-link"><b>Offer trip</b></div>
                        {{--</div>--}}
                        {{--<div class="disabled-popout inline-block">--}}
                        {{--Activate your account.--}}
                        {{--</div>--}}
                    @endif
                </li>
            @endif
            <li>

            </li>
        </ul>
    </div>
    <div class="user_navigation col-md-3">
        @if (Auth::check())
            <div class="dropdown-toggle top-dropdown-toggle" data-toggle="dropdown">
                <div class="dropdown">{{ Auth::user()->name }}
                    <div class="arrow-down"></div>
                </div>
            </div>
            <ul class="dropdown-menu pull-right profile-dropdown">
                <li class="profile-item first profile"><a href="{{ URL::route('account.myprofile') }}">Me<span
                                class="profile-menu-icon profile-icon"></span></a></li>
                <li class="profile-item edit"><a href="{{ URL::route('account.edit', ['id' => Auth::id()]) }}">Edit
                        profile<span
                                class="profile-menu-icon edit-icon"></span></a></li>
                <li class="profile-item trips"><a href="{{ URL::route('account.trips') }}">My trips<span
                                class="profile-menu-icon trips-icon"></span></a></li>
                <li class="profile-item account"><a
                            href="{{ URL::route('account.editAccount', ['id' => Auth::id()]) }}">Account<span
                                class="profile-menu-icon account-icon"></span></a></li>
                <li class="profile-item logout"><a href="{{ URL::route('account.logout') }}">Logout<span
                                class="profile-menu-icon logout-icon"></span></a></li>
            </ul>
        @else
            <ul class="nav navbar-nav navbar-right top-navigation">
                <li>
                    @include('shared._login')
                </li>
                <li>
                    {{ HTML::linkRoute('account.create', 'Register') }}
                </li>
            </ul>
        @endif


    </div>
</div>
