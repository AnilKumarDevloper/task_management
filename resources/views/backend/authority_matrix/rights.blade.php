@extends('layouts/backend/main')
@section('main_section') 

<div class="page-titles pb-0">
    <div class="row">
        <div class="col-lg-9 col-md-6 col-12 align-self-center">
            <nav aria-label="breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li>
                  <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.authority_matrix.index')}}" class="link">Authority Matrix</a></li>
                  <li class="breadcrumb-item" aria-current="page">Add/Remove Rights</li>
                 </ol>
            </nav>
            <h3 class="mb-0 fw-bold">Add/Remove Rights</h3>
        </div>   
    </div>
</div>

<div class="container-fluid"> 
      <div class="card_mainElement">
            <div class="card opacityClass" style="overflow: hidden;">
                   
                    <div class="card-body border-top">
                        <h4>Add/Remove Rights</h4>
                       <form action="{{route('backend.authority_matrix.sync_rights')}}" method="POST">
                        @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="inputcom" class="control-label col-form-label">User Name<b class="text-danger" >*</b></label>
                                        <input type="text" class="form-control" id="inputcom" placeholder="User Name" value="{{$user->name}}" disabled>
                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="control-label col-form-label">Rights</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="view" id="view" name="rights[]" {{in_array('view', $rights) ? 'checked':''}}/>
                                            <label class="form-check-label" for="view">View</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="edit" id="edit" name="rights[]" {{in_array('edit', $rights) ? 'checked':''}}/>
                                            <label class="form-check-label" for="edit">Edit</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="delete" id="delete" name="rights[]" {{in_array('delete', $rights) ? 'checked':''}}/>
                                            <label class="form-check-label" for="delete">Delete</label>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                             
                            <div class="p-3 border-top">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-info px-4 waves-effect waves-light">
                                       Submit
                                    </button>
                                </div>
                            </div>
                       </form> 
                    </div>
            </div>
      </div>

</div>

@section('javascript_section') 
 @if(Session::has('right_updated'))
<script>
     Swal.fire({
        title: "Success",
        text: "{{Session::get('right_updated')}}",
        icon: "success"
    });
</script>
@endif

@endsection

@endsection