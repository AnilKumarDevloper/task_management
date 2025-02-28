@php
    $layout_setting = \App\Models\Backend\LayoutSetting::where('id', 1)->first();
@endphp
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
    <div class="form_starts">
          <div class="leftSections">
              <div class="d-flex align-items-center justify-content-center gap-2 athunticatElement" >
                    <img src="{{url($layout_setting->logo_image_path . '/' . $layout_setting->logo_image)}}" alt="logo" style="width:100px">
                      <span>
                      <b style="color:#195e90; font-size:18px; font-weight:bold;">NDM Advisors LLP</b>
                      <p style="font-size:16px; color:#9e7400; line-height: 17px;" class="m-0 p-0">Secretarial Compliance
                      <br>
                        Management (SCM)
                      </p>
                    </span>
                </div>
          </div>
          <div class="rightSections">
              <div class="formsiez">
              <div class="bg-white roundedBox" style="padding:15px 20px 20px 20px">
                <div id="login">
                  <div class="logo d-flex justify-content-between">
                    <h3 class="box-title mb-3">Sign In</h3>
                    <div class="d-flex align-items-center justify-content-center gap-1">
                      <img src="{{url($layout_setting->logo_image_path . '/' . $layout_setting->logo_image)}}" alt="logo" style="width:40px">
                      <span>
                        <b style="color:#195e90; font-size:14.5px; font-weight:bold;">NDM Advisors LLP</b>
                        <p style="font-size:11px; color:#9e7400; line-height: 11px;" class="m-0 p-0">Secretarial Compliance
                        <br>
                          Management (SCM)
                        </p>
                      </span>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-12">
                      <form class="form-horizontal mt-3 form-material" id="loginform" method="POST" action="{{ route('login_store') }}">
                        @csrf
                        <div class="form-group mb-3">
                          <div class="">
                            <x-text-input id="email" class="form- formInput_control" type="email" name="email" :value="old('email')" placeholder="Enter Your Email" required autofocus autocomplete="username" />
                            @error('email')
                              <p style="color:red;" id="error_msg">{{$message}}</p>
                            @enderror
                            @error('error')
                              <p style="color:red;" id="error_msg">{{$message}}</p>
                            @enderror
                          </div>
                        </div>
                        <div class="form-group mb-4">
                          <div class="position-relative">
                            <x-text-input id="password"  class="form- formInput_control" type="password" name="password" placeholder="Your Password" required autocomplete="current-password" />
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" id="toggle-password"><i class="fas fa-eye"></i></span>
                            <x-input-error :messages="$errors->get('password')" class="mt-2"  id="error_msg"/>
                            <br>
                            <p style="color:green" id="sending_otp_text"></p>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="d-flex">
                            <div class="checkbox checkbox-info pt-0">
                              <input id="checkbox-signup" type="checkbox" class="material-inputs chk-col-indigo" name="remember">
                              <label for="checkbox-signup"> Remember me </label>
                            </div>
                            <div class="ms-auto">
                              <a href="{{route('password.request')}}" class="d-flex align-items-center link font-weight-medium forgetopen"><i class="ri-lock-line me-1 fs-4"></i> Forgot password?</a>
                            </div>
                          </div>
                        </div>
                        <div class="form-group text-center mt-4 mb-3">
                          <div class="col-xs-12">
                            <button class="btn btn-info d-block w-100 waves-effect waves-light"   id="submit_btn">Log In</button>
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
  </div>
  <script src="{{url('assets/backend/assets/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{url('assets/backend/css/myscript.js')}}"></script>
  <script src="{{url('assets/backend/libs/jquery/dist/jquery.min.js')}}"> </script>
<script src="{{url('assets/backend/extra-libs/taskboard/js/jquery-ui.min.js')}}"></script>
  <script>
    document.getElementById('toggle-password').addEventListener('click', function (){
      const passwordInput = document.getElementById('password');
      const icon = this.querySelector('i');
      if (passwordInput.type === 'password'){
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      }else{
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });

    // $(document).on("submit", "#loginform", function(e){
    
    //   console.log('clicked');
  
    // });
    $(document).ready(function(){
       
      $('#loginform').on('submit', function(){
      $("#sending_otp_text").text('Sending OTP Please wait...');
      document.getElementById("submit_btn").disabled = true;
      $("#error_msg").text('');
      })
    })
  </script>
</body>
</html>