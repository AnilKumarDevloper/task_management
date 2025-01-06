@extends('layouts/backend/main')
@section('main_section')  
    <div class="page-ti" style="padding: 20px 30px 10px 30px;">
                <div class="row">
                    <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-flex align-items-center">
                            <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.client.index')}}" class="link">Client Management</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);" class="link">Edit Client</a></li>
                        </ol>
                        </nav>
                        <h3 class="mt-3 mb-0 fw-bold text-white">Edit Client</h3>
                    </div>
                    <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
                    </div>
                </div>
            </div> 
            <div class="container-fluid">

    <div class="card opacityClass" style="overflow:hidden">
        <div class="max_width" style="padding:10px 30px; border: 1px solid gainsboro;">
            <form action="{{route('backend.client.update', [Crypt::encrypt($user->id)])}}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row lable_font">
                    <div class="col-md-4 mt-4">
                        <label class="control-label">Company Name</label>
                        <input class="form-control form-white input_border" name="company_name" placeholder="Company Name"
                            type="text" value="{{$user->GetCompanyDetail?->name}}">
                        @error('company_name')
                            <p style="color:red;">{{$message}}</p>
                        @enderror
                    </div>
        
                    <div class="col-md-4 mt-4">
                        <label class="control-label">Company Phone</label>
                        <input class="form-control form-white input_border" name="company_phone" placeholder="Company Number"
                            type="number" value="{{$user->GetCompanyDetail?->phone}}">
                        @error('company_phone')
                            <p style="color:red;">{{$message}}</p>
                        @enderror
                    </div>
        
                    <div class="col-md-4 mt-4">
                        <label class="control-label">Company Address</label>
                        <input class="form-control form-white input_border" name="company_address" placeholder="Company Address"
                            type="text" value="{{$user->GetCompanyDetail?->address}}">
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
                            value="{{$user->name ?? ''}}">
                        @error('user_name')
                            <p style="color:red;">{{$message}}</p>
                        @enderror
                    </div>
        
                    <div class="col-md-4 mt-4">
                        <label class="control-label">User Phone</label>
                        <input class="form-control form-white input_border" name="phone" placeholder="User Phone" type="text"
                            value="{{$user->phone ?? ''}}">
                        @error('phone')
                            <p style="color:red;">{{$message}}</p>
                        @enderror
                    </div>
        
                    <div class="col-md-4 mt-4">
                        <label class="control-label">User Email</label>
                        <input class="form-control form-white input_border" name="email" placeholder="User Email" type="email"
                            value="{{$user->email ?? ''}}">
                        @error('email')
                            <p style="color:red;">{{$message}}</p>
                        @enderror
                    </div>
                    <!-- <div class="col-md-4 mt-4">
                    <label class="control-label">Select User</label>
                    <select class="form-control" style="background-color: #fff; border: 1px solid gainsboro;">
                        <option>--Select user --</option>
                        <option>User Name 1</option>
                        <option>User Name 2</option>
                        <option>User Name 3</option>
                        <option>User Name 4</option>
                    </select>
                </div> -->
        
                    <div class="col-md-4 mt-4">
                        <label class="control-label">Enter password if you want to change</label>
                        <input class="form-control form-white input_border" name="password" placeholder="password" type="text">
                        @error('password')
                            <p style="color:red;">{{$message}}</p>
                        @enderror
                    </div>
        
                    <div class="col-12 mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary waves-effect waves-lightsave-category">
                            Update Client
                        </button>
                    </div>
        
                </div>
            </form>
        </div>
    </div>

</div> 
@endsection