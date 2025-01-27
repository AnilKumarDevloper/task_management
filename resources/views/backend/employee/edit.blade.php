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
                    <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);" class="link">Edit
                            Employee</a></li>
                </ol>
            </nav>
            <h3 class=" mt-3 mb-0 fw-bold text-white">Edit Employee</h3>
        </div>
        <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card opacityClass" style="overflow: hidden">
        <div class="max_width" style="padding:10px 30px; border: 1px solid gainsboro;">
            <form action="{{route('backend.employee.update', [Crypt::encrypt($user->id)])}}" method="POST">
                @csrf
                <div class="row lable_font">
                    <div class="col-md-4 mt-4">
                        <label class="control-label">Name</label>
                        <input type="text" name="name" class="form-control form-white input_border"
                            placeholder="Your name" value="{{$user->name ?? ''}}" required>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="control-label">Email</label>
                        <input name="email" class="form-control form-white input_border" placeholder="email id"
                            type="email" value="{{$user->email ?? ''}}" required>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label class="control-label">Phone Number</label>
                        <input type="number" name="phone" class="form-control form-white input_border"
                            placeholder="Phone Number" value="{{$user->phone ?? ''}}" required>
                    </div>

                    <!-- <div class="col-md-4 mt-4"> -->
                        <!-- <label for="clients" id="selectoptions" class="control-label">Select Client:</label> -->
                        <!-- <select id="clients" class="form-control mt-4 " aria-placeholder="Name" name="client">
                            <option value="">--Select--</option>
                            @foreach($clients as $client)
                                <option value="{{$client->id}}" {{$client->id == $user->getClient?->id ? 'selected' : ''}}>
                                    {{$client->name}}
                                </option>
                            @endforeach
                        </select> -->
                        <!-- <select class="form-control bg-white" name="client">
                                                <option value="">--Select--</option>
                                                @foreach($clients as $client)
                                                    <option value="{{$client->id}}" {{$client->id == $user->getClient?->id ? 'selected' : ''}}>
                                                        {{$client->name}}
                                                    </option>
                                                @endforeach
                            </select> -->
                    <!-- </div> -->

                    <!---new add selector --->
                    <div class="col-4 mt-4"> 
                        <label for="clients" id="selectoptions" class="control-label">Select Client:</label>
                        <div class="">
                            <select class="select2 form-control select2-hidden-accessible" multiple=""
                                style="height: 36px; width: 100%" data-select2-id="13" tabindex="-1" aria-hidden="true" name="clients[]">
                                @foreach($clients as $client)
                                <option value="{{$client->id}}" data-select2-id="{{$client->id}}"  {{ in_array($client->id, $assigned_clients) ? 'selected' : '' }}>{{$client->getCompanyDetail->name}}</option>  
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <!---new add selector end --->


                </div>

                <div class="col-12 mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary waves-effect waves-lightsave-category">
                        Update Employee
                    </button>
                </div>
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
            placeholder: "Select Clients",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endsection

@endsection