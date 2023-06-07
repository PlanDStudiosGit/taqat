<div class="header-area">
    <div class="row">
        {{ $breadCrumbs }}
        <div class="col-md-6">
            <div class="users">
                <ul>
                    <li><a href="javascript:;">{{ Auth::user()->name }}</a>
                        <!-- sub-user -->
                        <div class="sub-user">
                            <ul>
                                <li><a href="{{ route('logout') }}"><img class="img-fluid"
                                                                         src="{{ asset('img/sign-out.svg') }} "
                                                                         alt=""> Logout</a></li>
                            </ul>
                        </div>
                        <!-- sub-user -->
                    </li>
                    <li><a class="user-img" href="javascript:;"><img class="img-fluid"
                                                                     src="{{ asset('img/users.png') }} "
                                                                     alt=""></a></li>
                </ul>
            </div>
        </div>

    </div>
</div>
