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
                      <h3 class="box-title mb-3">Reset Password</h3>
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
                        <form class="form-horizontal mt-3 form-material" method="POST" action="{{ route('password.store') }}">
                          @csrf
                          <input type="hidden" name="token" value="{{ $request->route('token') }}">
                          <div class="form-group mb-3">
                            <div class="">
                              <x-input-label for="email" :value="__('Email')" />
                              <x-text-input id="email" class="form- formInput_control" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                              <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                          </div>
                          <div class="form-group mb-4">
                            <div class="position-relative">
                              <x-input-label for="password" :value="__('Password')" />

                              <div class="formInput_control bg-white d-flex align-items-center">
                                  <x-text-input id="password" class="form- bg-white w-100  pr-5" type="password" aria-placeholder="Password" name="password" required
                                  autocomplete="new-password"  style="border: none; outline: none;"/>
                                    <i class="fas fa-eye toggle-password"  data-target="password" style="cursor: pointer;"></i>
                              </div>
                              <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                          </div>
                          <div class="form-group mb-4">
                            <div class="position-relative">
                              <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                              <div class="formInput_control bg-white d-flex align-items-center">
                                   <x-text-input id="password_confirmation" class="form- pr-5 w-100" aria-placeholder="Confirm Password" type="password"
                                    name="password_confirmation" required autocomplete="new-password" style="border: none; outline: none;" />
                                  <i class="fas fa-eye toggle-password"  data-target="password_confirmation" style="cursor: pointer;"></i>
                              </div> 

                              <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                          </div>

                          <div class="form-group text-center mt-4 mb-3">
                            <div class="col-xs-12">
                              <button class="btn btn-info d-block w-100 waves-effect waves-light" type="submit">
                                Reset Password
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
  </div>
  <script src="{{url('assets/backend/assets/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{url('assets/backend/css/myscript.js')}}"></script>
  <script>
    document.querySelectorAll('.toggle-password').forEach(button =>
    {
      button.addEventListener('click', () =>
      {
        const target = document.getElementById(button.getAttribute('data-target'));
        const icon = button.querySelector('i');
        if (target.type === 'password')
        {
          target.type = 'text';
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        } else
        {
          target.type = 'password';
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
      });
    });

  </script>
</body>

</html>