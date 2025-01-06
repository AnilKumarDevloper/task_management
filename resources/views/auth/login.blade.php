{{--
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
--}}
 
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
                <h3 class="box-title mb-3">Sign In</h3>
              </div>
              <div class="row">
                <div class="col-12">
                  <form class="form-horizontal mt-3 form-material" id="loginform" method="POST" action="{{ route('login_store') }}">
                    @csrf  
                    <div class="form-group mb-3">
                      <div class="">
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        @error('email')
                          <p style="color:red;">{{$message}}</p>
                        @enderror 
                      </div>
                    </div>
                    <div class="form-group mb-4">
                      <div class="position-relative">
                        <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password"/>
                        <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" id="toggle-password"><i class="fas fa-eye"></i></span>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="d-flex">
                        <div class="checkbox checkbox-info pt-0">
                          <input id="checkbox-signup" type="checkbox" class="material-inputs chk-col-indigo">
                          <label for="checkbox-signup"> Remember me </label>
                        </div>
                        <div class="ms-auto">
                          <a href="{{route('password.request')}}" class="d-flex align-items-center link font-weight-medium forgetopen"><i class="ri-lock-line me-1 fs-4"></i> Forgot password?</a>
                        </div>
                      </div>
                    </div>
                    <div class="form-group text-center mt-4 mb-3">
                      <div class="col-xs-12">
                        <button class="btn btn-info d-block w-100 waves-effect waves-light" type="submit">Log In</button>
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
  <script>
    document.getElementById('toggle-password').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i'); 
        if(passwordInput.type === 'password'){
          passwordInput.type = 'text';
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        }else{
          passwordInput.type = 'password';
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
    });
</script> 
</body>
</html>