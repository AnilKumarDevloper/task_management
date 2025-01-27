@extends('layouts/backend/main')
@section('main_section')  
<div class="page-ti" style="padding: 20px 30px 10px 30px;">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i
                                class="ri-home-3-line fs-5"></i></a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.employee.index')}}"
                            class="link">Employee Management</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);" class="link">Add
                            Employee</a></li>
                </ol>
            </nav>
            <h3 class="mt-2 mb-0 fw-bold text-white">Add Employee</h3>
        </div>
        <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="max_width card opacityClass" style="padding:10px 30px; border: 1px solid gainsboro;">
        <form action="{{ route('backend.employee.store') }}" method="POST">
            @csrf
            <div class="row lable_font">
                <div class="col-md-4 mt-4">
                    <label class="control-label">Name</label>
                    <input name="name" class="form-control form-white input_border" placeholder="Your name" type="text"
                        oninput="capitalizeEachWord(this)">
                    @error('name')
                        <p style="color:red;">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-4 mt-4">
                    <label class="control-label">Phone Number</label>
                    <input type="tel" class="form-control form-white input_border" placeholder="Phone" id="phone"
                        name="phone" value="{{ old('phone') }}" maxlength="10" minlength="10" pattern="\d{10}"
                        oninput="validatePhone(this)" />
                    @error('phone')
                        <p style="color:red;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-md-4 mt-4">
                    <label class="control-label">Email</label>
                    <input name="email" class="form-control form-white input_border" placeholder="Email" type="email">
                    @error('email')
                        <p style="color:red;">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-4 mt-4">
                    <label class="control-label">Password</label>
                    <div class="input-group">
                        <input name="password" class="form-control form-white input_border" placeholder="Password"
                            type="password" id="password">
                        <span class="input-group-text" onclick="togglePasswordVisibility('password')">
                            <i class="fa fa-eye" id="togglePasswordIcon"></i>
                        </span>
                    </div>
                    @error('password')
                        <p style="color:red;">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-md-4 mt-4">
                    <label class="control-label">Confirm Password</label>
                    <div class="input-group">
                        <input name="password_confirmation" class="form-control form-white input_border"
                            placeholder="Confirm Password" type="password" id="confirm_password">
                        <span class="input-group-text" onclick="togglePasswordVisibility('confirm_password')">
                            <i class="fa fa-eye" id="toggleConfirmPasswordIcon"></i>
                        </span>
                    </div>
                    @error('password_confirmation')
                        <p style="color:red;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- <div class="col-md-4 mt-4"> 
                        <label for="clients" id="selectoptions" class="control-label">Select Client:</label>
                        <select id="clients" class="form-multi-select form-control select2 mt-4" multiple="multiple" name="clients[]">
                            @foreach($clients as $client)    
                            <option value="{{ $client->id }}">{{ $client->name }}</option> 
                            @endforeach
                        </select> 
                    </div> -->

                <!-- <div class="col-md-4 mt-4">
                    <label for="clients" id="selectoptions" class="control-label">Select Client:</label>
                    <select class="form-control" name="client" id="client" style="background: white;" required>
                        <option value="">--Select--</option>
                        @foreach($clients as $client)    
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div> -->

                <div class="col-md-4 mt-4">
                    <label for="clients" id="" class="control-label">Select Client:</label>
                    <div class="">
                        <select class="select2 form-control select2-hidden-accessible focusBorder" multiple=""
                            style="height: 34px; width: 100%;" data-select2-id="13" tabindex="-1" aria-hidden="true" name="clients[]">
                            @foreach($clients as $client)
                            <option value="{{$client->id}}" data-select2-id="{{$client->id}}">{{$client->getCompanyDetail->name}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="col-12 mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary waves-effect waves-light save-category">
                        Add Employee
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@section('javascript_section')
<script>
    $(document).ready(function ()
    {
        $('#clients').select2({
            placeholder: "Select Client",
            allowClear: true,
            width: '100%'
        });
    });

    function togglePasswordVisibility(fieldId)
    {
        const passwordField = document.getElementById(fieldId);
        const icon = passwordField.nextElementSibling.querySelector('i');
        if (passwordField.type === 'password')
        {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else
        {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
@endsection