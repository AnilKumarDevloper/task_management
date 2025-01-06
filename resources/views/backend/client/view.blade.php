@extends('layouts/backend/main')
@section('main_section')  
    <div class="page-ti" style="padding: 20px 30px 10px 30px;">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                        <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.client.index')}}" class="link">Client Management</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);" class="link">View Client</a></li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between">
                    <h3 class="mb-0 fw-bold mt-3 text-white">View Client</h3>
                    <!-- this commented code is to upload csv file of task (a error is comming with column data like document_id ) -->
                    <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
                        <a href="javascript:void(0)" class="btn d-flex align-items-center justify-content-center d-block w-100 btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="ri-add-line fs-6 me-2"></i> Import Task CSV </a>
                    </div>  
                </div>
            </div>
            <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end"></div>
        </div>
    </div>   
    <div class="container-fluid">
        <div class="card opacityClass" style="overflow:hidden">
            <div class="max_width" style="padding:10px 30px; border: 1px solid gainsboro;">
                <form action="{{route('backend.client.update', [Crypt::encrypt($user->id)])}}" method="POST">
                    @csrf
                    <div class="row lable_font">
                        <div class="col-md-4 mt-4">
                            <label class="control-label">Company Name</label>
                            <input class="form-control form-white input_border" name="company_name" placeholder="Company Name" type="text" value="{{$user->GetCompanyDetail?->name}}" disabled>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label class="control-label">Company Phone</label>
                            <input class="form-control form-white input_border" name="company_phone" placeholder="Company Number" type="number" value="{{$user->GetCompanyDetail?->phone}}" disabled>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label class="control-label">Company Address</label>
                            <input class="form-control form-white input_border" name="company_address" placeholder="Company Address" type="text" value="{{$user->GetCompanyDetail?->address}}" disabled>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label class="control-label">User Name</label> <input class="form-control form-white input_border" name="user_name" placeholder="User Name" type="text" value="{{$user->name ?? ''}}" disabled>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label class="control-label">User Phone</label>
                            <input class="form-control form-white input_border" name="phone" placeholder="User Phone" type="text" value="{{$user->phone ?? ''}}" disabled>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label class="control-label">User Email</label>
                            <input class="form-control form-white input_border" name="email" placeholder="User Email" type="email" value="{{$user->email ?? ''}}" disabled>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label class="control-label text-dark mb-2">Company Logo</label>
                            @if($user->getCompanyDetail?->logo != '')
                               <div style="padding: 12px; border: 1px solid gray; width:35%; border-radius: 20px">
                                    <img src="{{url($user->getCompanyDetail?->logo_url . '/' . $user->getCompanyDetail?->logo)}}" width="100%;">
                                </div>
                            @else
                                <p>Logo Not Available</p>
                            @endif
                        </div> 
                    </div>
                </form>
            </div>
        </div>
    </div>  
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">Upload CSV File:</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('backend.task.import_csv', [$user->id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="col-md-12" for="csv_file"><b class="boldname mt-3">Upload CSV File:</b></label>
                            <input class="form-control form-white input_border" type="file" name="csv_file" id="csv_file" accept=".csv" required style="max-width: 500px; padding-top: 5px; padding-left: 10px; background-color:#ecf0f2">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-info" type="submit">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('javascript_section')
    @if(Session::has('csv_imported'))
        <script>
            Swal.fire({
                title: "Success",
                text: "{{Session::get('csv_imported')}}",
                icon: "success"
            });
        </script>
    @endif
 
    @if (Session::has('file_not_compatible'))
        <script>
            Swal.fire({
                title: "Error",
                text: "File is not compatible. Please upload correct file.",
                icon: "error"
            }); 
        </script>
    @endif

    @endsection
@endsection