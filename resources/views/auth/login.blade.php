<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('plugins/images/favicon.png')}}">
<title>POS - ITECHDOOR.COM</title>
<!-- Bootstrap Core CSS -->
<link href="{{asset('bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
<!-- animation CSS -->
<link href="{{asset('css/animate.css')}}" rel="stylesheet">
<!-- Custom CSS -->
<link href="{{asset('css/style.css')}}" rel="stylesheet">
<!-- color CSS -->
<link href="{{asset('css/colors/default.css')}}" id="theme"  rel="stylesheet">

</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="new-login-register" style="background: url("")">
      <div class="lg-info-panel">
              <div class="inner-panel">
                  <a href="javascript:void(0)" class="p-20 di"><img width="200" src="{{asset('plugins/images/logo.png')}}"></a>
                  <div class="lg-content">
                      <h2>POS by I TECH DOOR 2019 edition</h2>
                      <p class="text-muted">with this you can regulate your business and many more... </p>
                  </div>
              </div>
      </div>

      <div class="new-login-box">

            @if(session('message'))<span class="alert alert-danger text-center">{{session('message')}}</span>@endif
                <div class="white-box">
                    <h3 class="box-title m-b-0">Sign In to Admin</h3>
                    <small>Enter your details below</small>

                <form class="form-horizontal new-lg-form" method="post" id="loginform" action="{{route('post-login')}}">
                    @csrf
                    <div class="form-group  m-t-20">
                      <div class="col-xs-12">
                        <label>Email Address</label>
                        <input value="{{old('email')}}" class="form-control" type="text" name="email" placeholder="Email">

                          @if($errors->has('email'))
                              <span class="text-danger">{{$errors->first('email')}}</span>
                          @endif

                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12">
                        <label>Password</label>
                        <input class="form-control" type="password" name="password" placeholder="Password">
                        @if($errors->has('password'))<span class="text-danger">{{$errors->first('password')}}</span>@endif
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <div class="checkbox checkbox-info pull-left p-t-0">
                          <input name="remember" id="checkbox-signup" type="checkbox">
                          <label for="checkbox-signup"> Remember me </label>
                        </div>
                        <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">Log In</button>
                      </div>
                    </div>
                  </form>
                  <form class="form-horizontal" id="recoverform" action="#">
                    <div class="form-group ">
                      <div class="col-xs-12">
                        <h3>Recover Password</h3>
                        <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                      </div>
                    </div>
                    <div class="form-group ">
                      <div class="col-xs-12">
                        <input class="form-control" type="text" required="" placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                        <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                      </div>
                    </div>
                  </form>
                </div>
      </div>


</section>
<!-- jQuery -->
<script src="{{asset('plugins/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{asset('bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Menu Plugin JavaScript -->
<script src="{{asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js')}}"></script>

<!--slimscroll JavaScript -->
<script src="{{asset('js/jquery.slimscroll.js')}}"></script>
<!--Wave Effects -->
<script src="{{asset('js/waves.js')}}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{asset('js/custom.min.js')}}"></script>
<!--Style Switcher -->
<script src="{{asset('plugins/bower_components/styleswitcher/jQuery.style.switcher.js')}}"></script>
</body>

</html>
