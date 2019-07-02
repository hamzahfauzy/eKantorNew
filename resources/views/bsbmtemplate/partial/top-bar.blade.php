        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.html">eKantor BAPPEDA Asahan</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count">{{ auth()->user()->level == 'pegawai' ? count(auth()->user()->employee->notifications()) : ''}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    @if(auth()->user()->level == 'pegawai')
                                    @foreach(auth()->user()->employee->notifications() as $notification)
                                    @if(auth()->user()->employee->isPimpinan())
                                    <li>
                                        <a href="{{route('pimpinan.surat.show',$notification->id)}}">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">comment</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>Surat Masuk - {{$notification->perihal}}</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> {{$notification->created_at}}
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    @else
                                    <li>
                                        <a href="{{route('detail-surat-masuk',$notification->surat_masuk->id)}}">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">comment</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>Memo - {{$notification->surat_masuk->perihal}}</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 14 {{$notification->created_at}}
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    @endif
                                    @endforeach
                                    @endif
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>