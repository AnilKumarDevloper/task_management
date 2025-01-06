@extends('layouts/backend/main')
@section('main_section') 
<div class="page-titles pb-0">
    <div class="row">
        <div class="col-lg-9 col-md-6 col-12 align-self-center"> 
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.authority_matrix.index')}}" class="link">Authority Matrix</a></li>
                    <li class="breadcrumb-item" aria-current="page">Request Additional Rights</li>
                </ol>
            </nav>
            <h3 class="mb-0 fw-bold">Request Additional Rights</h3>
        </div> 
    </div>
</div>
<div class="container-fluid"> 
    <div class="card_mainElement opacityClass">
        <div class="card opa">
            <div class="card-body">
                <h4>Request Additional Rights</h4>
                <form action="{{route('backend.additional_rights_request.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="inputcom" class="control-label col-form-label">Ticket being raised by<b class="text-danger" >*</b></label>
                                <input type="text" class="form-control" id="inputcom" placeholder="User Name" value="{{Auth::user()->name}}" disabled>
                            </div>
                        </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="control-label col-form-label">Attachment</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="form-control" id="attachment" name="attachment" accept=".jpg, .jpeg, .png, .webp, .docx, .doc, .xlsx, .ppt" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="control-label col-form-label">Reason<b class="text-danger">*</b></label>
                                <textarea class="form-control" placeholder="Details of Reason.." name="reason"></textarea>
                                @error('reason')
                                <p style="color:red">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="p-3 border-top">
                        <div class="text-end">
                            <button type="submit" class="btn btn-info px-4 waves-effect waves-light">Submit</button>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>  
</div>
@section('javascript_section') 
 <!-- <script>
    $(document).on("change", "#attachment", function(){
        let file = this.files[0];
        if(file){
            console.log(file.name);
        }
    })
 </script> --> 
@endsection 

@endsection