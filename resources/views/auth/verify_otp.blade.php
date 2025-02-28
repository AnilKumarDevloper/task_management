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
                        <h3 class="box-title mb-3">Verify OTP</h3>
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
                          <form class="form-horizontal mt-3 form-material" id="loginform" method="POST" action="{{ route('verify_otp_submit') }}">
                            @csrf
                            <div class="form-group mb-3">
                              <div class="">
                                <x-text-input id="otp" class="form- formInput_control" placeholder="Enter OTP" type="text" name="otp" :value="old('otp')" required autofocus/>
                                @error('otp')
                                  <p style="color:red;">{{$message}}</p>
                                @enderror
                                @error('error')
                                  <p style="color:red;">{{$message}}</p>
                                @enderror
                              </div>
                            </div> 
                            <input type="hidden" value="{{ $decrypt_id }}" name="user_id">
                            <div class="form-group text-center mt-4 mb-3">
                              <div class="col-xs-12">
                                <button class="btn btn-info d-block w-100 waves-effect waves-light" type="submit">Verify</button>
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
 
</body>
</html>