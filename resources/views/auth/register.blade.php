

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PT CAI | Daftar</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="form login_form">
          <section class="login_content">
           <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                    <h1>Create Account</h1>
                    <hr>
                        <div>
                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>

                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>                 
                        <div>
                            <input id="nama" type="text" class="form-control" name="nama" value="{{ old('nama') }}" placeholder="Nama" required autofocus>

                            @if ($errors->has('nama'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nama') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div>
                            <input id="level" type="text" class="form-control" name="level" value="{{ old('level') }}" placeholder="Level Jabatan" required autofocus>

                            @if ($errors->has('level'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('level') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div>
                            <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Ulangi Password" required>
                        </div>
                    
                        <div>
                            <button type="submit" class="btn btn-default">
                                Register
                            </button>
                        </div>
                     
                    </form>
                     <div class="clearfix"></div>

              <div class="separator">
              
                <div class="clearfix"></div>
                <br />

                <div>
                  <!-- <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1> -->
                  <p>©2017 All Rights Reserved. PT. CAI</p>
                </div>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>



