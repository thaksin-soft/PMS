<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        <nav class="nav navbar-nav">
            <ul class=" navbar-right">


                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
                        data-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('images/none-user.png') }}" alt=""><span
                            class="lao-font">{{ Auth::user()->roles->first()->display_name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="javascript:;"> Profile</a>
                        <a class="dropdown-item" href="javascript:;">
                            <span class="badge bg-red pull-right">50%</span>
                            <span>Settings</span>
                        </a>
                        <a class="dropdown-item" href="javascript:;">Help</a>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();"><i class="fa fa-sign-out pull-right"></i> Log
                                Out</a>
                        </form>

                    </div>
                </li>
                <li class="nav-item lao-font mr-4 p-1" style="margin-top: 1px;">
                    <form class="form-inline" id="form-base">
                        @php
                            if (session()->has('choose-base')) {
                                $base = session()->get('choose-base');
                            } else {
                                $base = 'od';
                                session()->put('choose-base', 'od');
                            }
                            
                            if ($base == 'od') {
                                $ch_od = 'checked';
                                $ch_pp = '';
                            } else {
                                $ch_pp = 'checked';
                                $ch_od = '';
                            }
                        @endphp
                        <div class="custom-control custom-switch pr-4">
                            <input type="radio" class="custom-control-input" id="rd-odien" name="from-base"
                                {{ $ch_od }} value="odien" onchange="set_choose_base('od')">
                            <label class="custom-control-label" for="rd-odien"
                                style="padding-top: 5px; color: black">ODIEN</label>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="radio" class="custom-control-input" id="rd-pp" name="from-base" value="p&p"
                                onchange="set_choose_base('pp')" {{ $ch_pp }}>
                            <label class="custom-control-label" for="rd-pp"
                                style="padding-top: 5px; color: black">P&P</label>
                        </div>
                    </form>
                </li>
                {{-- <li role="presentation" class="nav-item dropdown open">
                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1"
                        data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-green">6</span>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                        <li class="nav-item">
                            <a class="dropdown-item">
                                <span class="image"><img src="{{ asset('images/img.jpg') }}"
                                        alt="Profile Image" /></span>
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item">
                                <span class="image"><img src="{{ asset('images/img.jpg') }}"
                                        alt="Profile Image" /></span>
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item">
                                <span class="image"><img src="{{ asset('images/img.jpg') }}"
                                        alt="Profile Image" /></span>
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-item">
                                <span class="image"><img src="{{ asset('images/img.jpg') }}"
                                        alt="Profile Image" /></span>
                                <span>
                                    <span>John Smith</span>
                                    <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="text-center">
                                <a class="dropdown-item">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </nav>
    </div>
</div>
<script>
    function set_choose_base(base) {
        $.ajax({
            url: "{{ route('chose-base') }}",
            method: "get",
            data: {
                'base': base
            },
            success: function(e) {
                console.log(e);
                if (e == 'success') {
                    location.reload();
                }
            }
        })
    }
</script>
