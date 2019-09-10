        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info" style="background: url('{{ asset("images/user-img-background.jpg") }}') no-repeat no-repeat;">
                <div class="image">
                    <img src="{{asset('images/user.png')}}" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{auth()->user()->name}}</div>
                    <div class="email">{{auth()->user()->email}}</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{route('profil')}}"><i class="material-icons">person</i>Profile</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{csrf_field()}}
                        </form>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="@yield('home-active')">
                        <a href="{{route('home')}}">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    @if(auth()->user()->level == 'admin')
                    <li class="@yield('kepegawaian-active')">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">widgets</i>
                            <span>Kepegawaian</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="@yield('golongan-active')">
                                <a href="{{route('reference.golongan.index')}}">
                                    Golongan
                                </a>
                            </li>
                            <li class="@yield('eselon-active')">
                                <a href="{{route('reference.eselon.index')}}">
                                    Eselon
                                </a>
                            </li>
                            <li class="@yield('pegawai-active')">
                                <a href="{{route('reference.employee.index')}}">
                                    Pegawai
                                </a>
                            </li>
                            <li class="@yield('group-active')">
                                <a href="{{route('reference.group.index')}}">
                                    Group
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="@yield('pkr-active')">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">text_fields</i>
                            <span>Program & Kegiatan</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="@yield('program-active')">
                                <a href="{{route('reference.program.index')}}">
                                    Program
                                </a>
                            </li>
                            <li class="@yield('kegiatan-active')">
                                <a href="{{route('reference.kegiatan.index')}}">
                                    Kegiatan
                                </a>
                            </li>
                            {{--
                            <li class="@yield('rekening-active')">
                                <a href="{{route('reference.rekening.index')}}">
                                    Rekening
                                </a>
                            </li>
                            --}}
                        </ul>
                    </li>
                    <li class="@yield('spt-sppd-active')">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">dvr</i>
                                <span>SPT & SPPD</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="@yield('spt-active')">
                                    <a href="#">
                                        SPT
                                    </a>
                                </li>
                                <li class="@yield('sppd-active')">
                                    <a href="#">
                                        SPPD
                                    </a>
                                </li>
                            </ul>
                    </li>
                    <li class="@yield('wilayah-active')">
                        <a href="{{route('reference.wilayah.index')}}">
                            <i class="material-icons">flight_takeoff</i>
                            <span>Wilayah Tujuan</span>
                        </a>
                    </li>
                    <li class="@yield('transportasi-active')">
                        <a href="{{route('reference.transportasi.index')}}">
                            <i class="material-icons">motorcycle</i>
                            <span>Transportasi</span>
                        </a>
                    </li>
                    <li class="@yield('setting-active')">
                        <a href="{{route('setting.index')}}">
                            <i class="material-icons">build</i>
                            <span>Setting</span>
                        </a>
                    </li>
                    @else
                        <li class="@yield('surat-active')">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">email</i>
                                <span>Surat</span>
                            </a>
                            <ul class="ml-menu">
                                @if(auth()->user()->employee->isPimpinan())
                                <li class="@yield('surat-masuk-pimpinan-active')">
                                    <a href="{{route('pimpinan.surat.index')}}">
                                        Surat
                                    </a>
                                </li>
                                <li class="@yield('disposisi-active')">
                                    <a href="{{route('pimpinan.surat.disposisi')}}">
                                        Disposisi
                                    </a>
                                </li>
                                @endif
                                {{'',$spt_url = route('pegawai.spt.index')}}
                                @if(auth()->user()->employee->inSpecialRoleUser() && !auth()->user()->employee->kepala_group_special_role())
                                {{'',$spt_url = route('pegawai.spt-role.index')}}
                                <li class="@yield('surat-masuk-active')">
                                    <a href="{{route('pegawai.surat-masuk.index')}}">
                                        Surat Masuk
                                    </a>
                                </li>
                                @endif
                                <li class="@yield('surat-keluar-active')">
                                    <a href="{{route('pegawai.surat-keluar.index')}}">
                                        Surat Keluar
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="@yield('spt-sppd-active')">
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">dvr</i>
                                <span>SPT & SPPD</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="@yield('spt-active')">
                                    <a href="{{$spt_url}}">
                                        SPT
                                    </a>
                                </li>
                                <li class="@yield('sppd-active')">
                                    <a href="{{route('pegawai.sppd.index')}}">
                                        SPPD
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if(!auth()->user()->employee->isPimpinan())
                        <li class="@yield('disposisi-active')">
                            <a href="{{route('disposisi')}}">
                                <i class="material-icons">accessibility</i>
                                <span>Disposisi</span>
                            </a>
                        </li>
                        @endif
                        <li class="@yield('agenda-active')">
                            <a href="{{route('agenda.index')}}">
                                <i class="material-icons">view_agenda</i>
                                <span>Agenda</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2019 <a href="javascript:void(0);">eKantor - BAPPEDA Asahan</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red" class="active">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->