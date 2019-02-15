<!--<div class="dash_tabs">-->
<div class="dash_tabs">
    <ul>
        {{--<li class="{{ (Request::segments()[1] == 'myCars')?'current':'' }}">
            <a href="{{ route('admin.myCars.index') }}" title="New Requests">
                <span class="icon-icon-5"></span> Add Cars
            </a>
        </li>
        <li class="{{ (Request::segments()[1] == 'makeBids')?'current':'' }}">
            <a href="{{ route('admin.makeBids.index') }}" title="New Requests">
                <span class="icon-icon-5"></span> My Cars
            </a>
        </li>--}}
        <li class="{{ (Request::segments()[1] == 'tradeInCars')?'current':'' }}">
            <a href="{{ route('admin.tradeInCars.index') }}" title="New Requests">
                <span class="icon-icon-1"></span> New Requests <i class="badge">{{ $notifications->count() > 0 ? $notifications->count() : '' }}</i>
                    {{--Span--}}
                </a>

            </a>
        </li>
        <li class="{{ (Request::segments()[1] == 'bidsHistories')?'current':'' }}">
            <a href="{{ route('admin.bidsHistories.index') }}" title="Bid History">
                <span class="icon-icon-2"></span> Bid History
            </a>
        </li>
        <li class="{{ (Request::segments()[1] == 'user')?'current':'' }}">
            <a href="{{ route('admin.users.profile') }}" title="Profile">
                <span class="icon-icon-4"></span> My Profile
            </a>
        </li>
        <li class="{{ (Request::segments()[1] == 'myCars')?'current':'' }}">
            <a href="{{ route('admin.myCars.create') }}" title="Profile">
                <span class="icon-icon-4"></span> Add Cars
            </a>
        </li>
    </ul>
</div>