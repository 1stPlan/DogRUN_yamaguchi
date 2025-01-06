
<!DOCTYPE html>
<html lang="ja">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta name="description" content="Bootstrap Admin App">
   <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
   <link rel="icon" type="image/x-icon" href="favicon.ico">
   <title>DogRUN Admin login</title>
   
   <!-- =============== VENDOR STYLES ===============-->
   <!-- FONT AWESOME-->
   <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/brands.css') }}">
   <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/regular.css') }}">
   <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/solid.css') }}">
   <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/fontawesome.css') }}"><!-- SIMPLE LINE ICONS-->
   <link rel="stylesheet" href="{{ asset('vendor/simple-line-icons/css/simple-line-icons.css') }}">
   <!-- =============== BOOTSTRAP STYLES ===============-->
   <link href="{{ asset('css/admin/bootstrap.css') }}" rel="stylesheet">
   <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
</head>

<body>
   <div class="wrapper">
      <div class="block-center wd-xl mt-5">
         <!-- START card-->
         <div class="card card-flat">
            <div class="card-header text-center pt-4">
                <a href="#"><img class="block-center rounded" src="{{ asset('images/icon.png') }}" alt="Image" width="25%"></a>
            </div>
            <div class="card-body">
               <p class="text-center py-2">SIGN IN TO CONTINUE.</p>

               <form method="POST" action="{{ route('admin.login') }}"class="mb-3" id="loginForm">
                 @csrf

                  <div class="form-group">
                     <div class="input-group with-focus">
                       <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <div class="input-group-append">
                          <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fa fa-envelope"></em></span>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>
                   </div>

                   <div class="form-group">
                      <div class="input-group with-focus">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <div class="input-group-append"><span class="input-group-text text-muted bg-transparent border-left-0"><em class="fa fa-lock"></em></span></div>
                        @error('password')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                        </div>
                    </div>


                  <div class="clearfix"></div>
                  <button class="btn btn-block btn-primary mt-3" type="submit">Login</button>

                </div>
                </div>
               </form>
            </div>
         </div><!-- END card-->
      </div>
   </div>
   <!-- =============== VENDOR SCRIPTS ===============-->

   <script src="{{ asset('vendor/jquery/dist/jquery.js') }}"></script>
   <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.js') }}"></script>

   <!-- =============== APP SCRIPTS ===============-->
   <script src="{{ asset('js/admin/app.js') }}"></script>
</body>

</html>
