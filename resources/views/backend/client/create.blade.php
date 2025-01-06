@extends('layouts/backend/main')
@section('main_section')  
    <div class="page-ti" style="padding: 20px 30px 10px 30px;">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 d-flex align-items-center">
                                <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.client.index')}}" class="link">Client Management</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);" class="link">Add Client</a></li>
                            </ol>
                        </nav>
                        <h3 class=" mt-3 mb-0 fw-bold text-white">Add Client</h3>
                    </div>
                    <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
                    </div>
                </div>
            </div> 
            <div class="container-fluid">

<div class="card opacityClass " style="overflow:hidden">
        <div class="max_width" style="padding:10px 30px; border: 1px solid gainsboro;">
            <form action="{{route('backend.client.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row lable_font">
                    <div class="col-md-4 mt-4">
                        <label class="control-label">Company Name</label>
                        <input class="form-control form-white input_border" name="company_name" placeholder="Company Name"
                            type="text" value="{{old('company_name')}}" oninput="capitalizeEachWord(this)">
                        @error('company_name')
                            <p style="color:red;">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="control-label">Company Phone</label>
                        <input class="form-control form-white input_border" name="company_phone" placeholder="Company Number"
                            type="tel" value="{{old('company_phone')}}" maxlength="10" minlength="10" pattern="\d{10}"
                            oninput="validatePhone(this)">
                        @error('company_phone')
                            <p style="color:red;">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="control-label">Company Address</label>
                        <input class="form-control form-white input_border" name="company_address" placeholder="Company Address"
                            type="text" value="{{old('company_address')}}">
                        @error('company_address')
                            <p style="color:red;">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="control-label">Company Logo</label>
                        <input class="form-control form-white input_border" name="company_logo" placeholder="Company Address"
                            type="file" accept=".jpg, .jpeg, .png, .webp">
                        @error('company_logo')
                            <p style="color:red;">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="control-label">User Name</label>
                        <input class="form-control form-white input_border" name="user_name" placeholder="User Name" type="text"
                            value="{{old('user_name')}}" oninput="capitalizeEachWord(this)">
                        @error('user_name')
                            <p style="color:red;">{{$message}}</p>
                        @enderror
                    </div>
        
                    <div class="col-md-4 mt-4">
                        <label class="control-label">User Phone</label>
                        <input class="form-control form-white input_border" name="phone" placeholder="User Phone" type="tel"
                            value="{{old('phone')}}" maxlength="10" minlength="10" pattern="\d{10}"
                            oninput="validatePhone(this)">
                        @error('phone')
                            <p style="color:red;">{{$message}}</p>
                        @enderror
                    </div>
        
                    <div class="col-md-4 mt-4">
                        <label class="control-label">User Email</label>
                        <input class="form-control form-white input_border" name="email" placeholder="User Email" type="email"
                            value="{{old('email')}}">
                        @error('email')
                            <p style="color:red;">{{$message}}</p>
                        @enderror
                    </div>
        
                    <div class="col-md-4 mt-4">
                        <label class="control-label">Password</label>
                        <div class="input-group">
                            <input class="form-control form-white input_border" name="password" placeholder="Password"
                                type="password" id="password">
                            <span class="input-group-text" onclick="togglePassword('password')">
                                <i class="fas fa-eye" id="togglePasswordIconPassword"></i>
                            </span>
                        </div>
                        @error('password')
                            <p style="color:red;">{{$message}}</p>
                        @enderror
                    </div>
        
                    <div class="col-md-4 mt-4">
                        <label class="control-label">Confirm Password</label>
                        <div class="input-group">
                            <input class="form-control form-white input_border" name="password_confirmation"
                                placeholder="Confirm Password" type="password" id="password_confirmation">
                            <span class="input-group-text" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye" id="togglePasswordIconPasswordConfirmation"></i>
                            </span>
                        </div>
                        @error('password_confirmation')
                            <p style="color:red;">{{$message}}</p>
                        @enderror
                    </div>
        
                    <div class="col-12 mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary waves-effect waves-lightsave-category">
                            Add Client
                        </button>
                    </div>
        
                </div>
            </form>
        </div>
</div>

</div> 
@section('javascript_section')
<script>
    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const icon = document.getElementById(`togglePasswordIcon${fieldId.charAt(0).toUpperCase() + fieldId.slice(1)}`);
        
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.replace("fa-eye-slash", "fa-eye");
        }
    }
</script>
@endsection
@endsection