@extends('layouts/backend/main')
@section('main_section')  
    <div class="page-ti" style="padding: 20px 30px 10px 30px;">
                <div class="row">
                    <div class="col-12">
                    <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li>
                  <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.fy_year.index')}}" class="link">Financial Year List</a></li>
                  <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0)" class="link">Add Financial Year</a></li>
                </ol>
            </nav>
                        <h3 class="mt-3 mb-0 fw-bold">Add Client</h3>
                    </div>
                    <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
                    </div>
                </div>
            </div> 
            <div class="container-fluid">

<div class="card opacityClass" style="overflow: hidden;">
    <div class="max_width" style="padding:10px 30px; border: 1px solid gainsboro;">
<form action="{{route('backend.fy_year.store')}}" method="POST">
    @csrf
    <div class="row lable_font">
        <div class="col-md-4 mt-4">
            <label class="control-label">Year</label>
            <input class="form-control form-white input_border" name="name" placeholder="Year" type="text" value="{{old('name')}}" >
            @error('name')
            <p style="color:red;">{{$message}}</p>
            @enderror
        </div> 
        <div class="col-12 mt-4 d-flex justify-content-end"> 
            <button type="submit" class="btn btn-primary waves-effect waves-lightsave-category">
                Add
            </button>
        </div>

    </div>
</form>
</div>
</div>

</div> 
@section('javascript_section')
 
@endsection
@endsection