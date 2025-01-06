@extends('layouts/backend/main')
@section('main_section') 
 
<div class="container-fluid"> 
    <div class="row"> 
        <div class="row opacityClass"> 
            <div class="col-lg-8 col-md-6 col-12 align-self-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                        <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.client.index')}}" class="link">Profile</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-lg-4 col-xlg-3 col-md-5 opacityClass">
            <div class="card opacityClass h-100">
                <div class="card-body">
                    <center class="mt-4">
                        <div class="image_upload">
                            @if(Auth::user()->profile != '')
                                <img src="{{url(Auth::user()->profile)}}" class="rounded-circle" width="150" height="150">
                            @else
                                <img src="{{url('assets\backend\images\users\user.png')}}" class="rounded-circle" width="150" height="150">
                            @endif 
                        </div>
                        <h4 class="mt-2">{{Auth::user()->name}}</h4>
                        @if(Auth::user()->role_id == 1)
                        <p>Super Admin</p>
                        @elseif(Auth::user()->role_id == 2)
                        <p>Admin</p>
                        @elseif(Auth::user()->role_id == 3)
                        <p>Employee</p>
                        @elseif(Auth::user()->role_id == 4)
                        <p>Client</p>
                        @endif 
                    </center>
                </div>
                <div>
                <hr>
                </div>
                <div class="card-body">
                    <small class="text-muted"><b class="boldname">Email address</b></small>
                    <h6>{{Auth::user()->email}}</h6>
                    <small class="text-muted pt-4 db"><b class="boldname">Phone</b></small>
                    <h6>{{Auth::user()->phone}}</h6> 
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xlg-9 col-md-7 opacityClass">
            <div class="card overflow-hidden h-100">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-timeline-tab" data-bs-toggle="pill" href="" role="tab" aria-controls="pills-timeline" aria-selected="true">Setting</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="card-body">
                        <form class="form-horizontal form-material inputborderall" action="{{route('backend.profile.update')}}" enctype="multipart/form-data" method="POST">
                        @csrf    
                            <div class="mb-3">
                                <label class="col-md-12"><b class="boldname">Full Name</b></label>
                                <div class="col-md-12">
                                    <input type="text" name="name" placeholder="Your Name" class="form-control form-control-line" value="{{Auth::user()->name}}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="example-email" class="col-md-12"><b class="boldname">Email</b></label>
                                <div class="col-md-12">
                                    <input type="email" name="email" placeholder="Email" class="form-control form-control-line" value="{{Auth::user()->email}}" disabled>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="col-md-12"><b class="boldname"><b class="boldname">Phone No</b></b></label><b class="boldname">
                                <div class="col-md-12">
                                    <input type="text" name="phone" placeholder="Your Phone No." class="form-control form-control-line" value="{{Auth::user()->phone}}" >
                                </div>
                            </b>
                        </div>
                            <b class="boldname"> 
                                <div class="mb-3">
                                    <label class="col-md-12"><b class="boldname">Profile Image</b></label>
                                    <!-- <div class="col-md-12">
                                        <input type="file" accept="" class="file_upload" name="profile_image">
                                    </div> -->
                                <input class="form-control form-white input_border"  type="file"
                                    style="max-width: 500px; padding-top: 5px; padding-left: 10px; background-color:#ecf0f2"    accept=".png, .jpg, .webp, .jpeg" name="profile_image">
                                </div> 
                                <div class="mb-3">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success">
                                            Update Profile
                                        </button>
                                    </div>
                                </div> 
                            </b>
                </form>
            </div>
            <b class="boldname"></b>
        </div><b class="boldname"></b>
                </div> 
            </div> 
        </div> 
    </div>
@section('javascript_section')
@if(Session::has('profile_updated'))
<script>
    Swal.fire({
        title: "Success!",
        text: "{{Session::get('profile_updated')}}!",
        icon: "success"
    });
</script>
@endif
@endsection 
@endsection
