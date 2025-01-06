<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Task Management</title>
  <link rel="stylesheet" href="{{url('assets/backend/css/styles.css')}}">
  <link href="{{url('assets/backend/dist/css/style.min.css')}}" rel="stylesheet" />
</head>
<body>

  <div class="body_form">
    <div class="form_start">
      <div class="formsiez">
        <div class="p-4 bg-white rounded ">
          <div id="login">
            <div class="logo">
              <h3 class="box-title mb-3">Forget Password</h3>
            </div>
            <div class="row">
              <div class="col-12">
                <form class="form-horizontal mt-3 form-material" id="loginform" method="POST" action="{{ route('password.email') }}">
                @csrf  
                <div class="form-group mb-3">
                    <div class="">
                    <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />    
                </div>
                  </div> 
                  <div class="form-group">
                    <div class="d-flex"> 
                      <div class="ms-auto">
                        <a href="{{route('login')}}" class="d-flex align-items-center link font-weight-medium forgetopen"><i class="ri-user-line me-1 fs-4"></i> Login?</a>
                      </div>
                    </div>
                  </div>
                  <div class="form-group text-center mt-4 mb-3">
                    <div class="col-xs-12">
                      <button class="btn btn-info d-block w-100 waves-effect waves-light" type="submit">
                      Email Password Reset Link
                      </button>
                    </div>
                  </div> 
                </form>
              </div>
            </div>
          </div>
            
        </div>
      </div>
    </div>
  </div>
  <script src="{{url('assets/backend/assets/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{url('assets/backend/css/myscript.js')}}"></script>
</body>
</html>