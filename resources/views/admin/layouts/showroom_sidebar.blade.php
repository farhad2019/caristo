<div class="dash_tabs">
    <ul>
        <li class="{{ (Request::segments()[1] == 'makeBids')?'current':'' }}">
            <a href="{{ route('admin.makeBids.index') }}" title="New Requests">
                <span class="icon-icon-1"></span> New Requests
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
    </ul>
</div>