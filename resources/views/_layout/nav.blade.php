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
        <!-- Search input and Toggle icon -->
        <ul class="nav navbar-top-links navbar-left">
            <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a></li>
             <!-- .Megamenu -->
             <li class="mega-dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"><span class="hidden-xs">Menue</span> <i class="icon-options-vertical"></i></a>
                <ul class="dropdown-menu mega-dropdown-menu animated bounceInDown">
                    <li class="col-sm-3">
                        <ul>
                            <li class="dropdown-header">Forms Elements</li>
                            <li><a href="form-basic.html">Basic Forms</a></li>
                            <li><a href="form-layout.html">Form Layout</a></li>
                            <li><a href="form-advanced.html">Form Addons</a></li>
                            <li><a href="form-material-elements.html">Form Material</a></li>
                            <li><a href="form-float-input.html">Form Float Input</a></li>
                            <li><a href="form-upload.html">File Upload</a></li>
                            <li><a href="form-mask.html">Form Mask</a></li>
                            <li><a href="form-img-cropper.html">Image Cropping</a></li>
                            <li><a href="form-validation.html">Form Validation</a></li>
                        </ul>
                    </li>
                    <li class="col-sm-3">
                        <ul>
                            <li class="dropdown-header">Advance Forms</li>
                            <li><a href="form-dropzone.html">File Dropzone</a></li>
                            <li><a href="form-pickers.html">Form-pickers</a></li>
                            <li><a href="form-wizard.html">Form-wizards</a></li>
                            <li><a href="form-typehead.html">Typehead</a></li>
                            <li><a href="form-xeditable.html">X-editable</a></li>
                            <li><a href="form-summernote.html">Summernote</a></li>
                            <li><a href="form-bootstrap-wysihtml5.html">Bootstrap wysihtml5</a></li>
                            <li><a href="form-tinymce-wysihtml5.html">Tinymce wysihtml5</a></li>
                        </ul>
                    </li>
                    <li class="col-sm-3">
                        <ul>
                            <li class="dropdown-header">Table Example</li>
                            <li><a href="basic-table.html">Basic Tables</a></li>
                            <li><a href="table-layouts.html">Table Layouts</a></li>
                            <li><a href="data-table.html">Data Table</a></li>
                            <li><a href="bootstrap-tables.html">Bootstrap Tables</a></li>
                            <li><a href="responsive-tables.html">Responsive Tables</a></li>
                            <li><a href="editable-tables.html">Editable Tables</a></li>
                            <li><a href="foo-tables.html">FooTables</a></li>
                            <li><a href="jsgrid.html">JsGrid Tables</a></li>
                        </ul>
                    </li>
                    <li class="col-sm-3">
                        <ul>
                            <li class="dropdown-header">Charts</li>
                            <li> <a href="flot.html">Flot Charts</a> </li>
                            <li><a href="morris-chart.html">Morris Chart</a></li>
                            <li><a href="chart-js.html">Chart-js</a></li>
                            <li><a href="peity-chart.html">Peity Charts</a></li>
                            <li><a href="knob-chart.html">Knob Charts</a></li>
                            <li><a href="sparkline-chart.html">Sparkline charts</a></li>
                            <li><a href="extra-charts.html">Extra Charts</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <!-- /.Megamenu -->
        </ul>
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

