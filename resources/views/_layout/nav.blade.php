<nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header">
        {{-- <div class="top-left-part">
            <!-- Logo -->
        <a class="logo" href="{{url('/dashboard')}}">
                    <!--This is dark logo icon--><img  src="{{asset('plugins/images/logo.png')}}" alt="home" class="dark-logo" /><!--This is light logo icon--><img width="200" src="{{asset('plugins/images/logo.png')}}" alt="home" class="light-logo" />
            </a>
        </div> --}}
        <div class="top-left-part">
            <!-- Logo -->
            <a class="logo" href="{{url('/dashboard')}}" style="background: #2f323e !important">
                {{-- <!-- Logo icon image, you can use font-icon also --><b>
                <!--This is dark logo icon--><!--This is light logo icon--><img width="200" src="{{asset('plugins/images/logo.png')}}" alt="home" class="light-logo" />
             </b> --}}
                <!-- Logo text image you can use text also --><span class="hidden-xs">
                <!--This is dark logo text--><img src="../plugins/images/admin-text.png" alt="home" class="dark-logo" /><!--This is light logo text--><img width="200" src="{{asset('plugins/images/logo.png')}}" alt="home" class="light-logo" />
             </span>
             <span class="hidden-sm hidden-md hidden-lg show-xs p-l-10 font-bold text-warning">I.T.C</span>
            </a>
        </div>
        <!-- /Logo -->
        <ul class="nav navbar-top-links navbar-right pull-right">

            <li class="dropdown">
                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">{{auth()->user()->name}}</b><span class="caret"></span> </a>
                <ul class="dropdown-menu dropdown-user animated flipInY">
                    <li>
                        <div class="dw-user-box">
                            <div class="u-img"><img src="plugins/images/users/varun.jpg" alt="user" /></div>
                            <div class="u-text">
                                <h4>{{auth()->user()->name}}</h4>
                            <p class="text-muted">{{auth()->user()->email}}</p><a href="{{url('/dashboard')}}" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                        </div>
                    </li>
                    {{-- <li role="separator" class="divider"></li> --}}
                    {{-- <li><a href="#"><i class="ti-user"></i> Users</a></li> --}}
                    <li role="separator" class="divider"></li>
                        <li>
                            <a style="display: block;
                        padding: 3px 20px;
                        clear: both;
                        font-weight: 400;
                        line-height: 1.42857143;
                        color: #333;
                        white-space: nowrap;" onClick="document.getElementById('logout-form').submit();" href="javascript:"><i class="fa fa-power-off"></i> Logout</a>
                        </li>
                </ul>

                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
    </div>
    <!-- /.navbar-header -->
    <!-- /.navbar-top-links -->
    <!-- /.navbar-static-side -->
</nav>

