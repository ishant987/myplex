<div class="content-form bg-lightblue">
    <div class="list-group">
        <a href="{{ route('web.myaccount') }}" class="list-group-item list-group-item-action{{ request()->routeIs('web.myaccount') ? ' active' : '' }}">
            My Account
        </a>
        <a href="{{ route('web.edit.profile') }}" class="list-group-item list-group-item-action{{ request()->routeIs('web.edit.profile') ? ' active' : '' }}">
            Edit Profile
        </a>
        <a href="{{ route('web.reset.password') }}" class="list-group-item list-group-item-action{{ request()->routeIs('web.reset.password') ? ' active' : '' }}">
            Reset Password
        </a>
        @auth
        <a href="{{ route('user.logout') }}" class="list-group-item list-group-item-action">
            Logout
        </a>
        @endauth
    </div>
</div>
