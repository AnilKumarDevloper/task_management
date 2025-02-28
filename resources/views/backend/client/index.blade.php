@extends('layouts/backend/main')
@section('main_section') 

<div class="page-titles" >
        <div class="row">
          <div class="col-lg-8 col-md-6 col-12 align-self-center">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb mb-0 d-flex align-items-center">
                <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);" class="link">Client Management</a></li>
              </ol>
            </nav>
            <h1 class="mb-0 fw-bold">Client Management</h1>
          </div>
          @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
          <div class=" col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
            <a href="{{route('backend.client.create')}}"  class="btn d-flex align-items-center justify-content-center d-block w-100 btn-info waves-effect waves-light">
              <i class="ri-add-line fs-6 me-2"></i>Add Client</a>
          </div>
          @endif
        </div>
      </div>
      @php $sn = 1; @endphp
      <div class="container-fluid">
        <div class="card opacityClass" style="border-radius: 10px;  padding: 20px">
 
          <!-- <div class="col-12 mb-3">
            <div class="form-group d-flex justify-content-end gap-1">
              <form method="GET" action="">
                <div class="d-flex gap-2">
                  <input type="text search_input_Box_Eleemnt" class="form-control" id="" placeholder="Search here..."
                    style="border: 1px solid #54667a; min-width:250px;" name="" value="" aria-label="Search Title">
                  <button class="btn btn-info">Search</button>
                </div>
              </form>
              <div class="clear_btn">
                <a href="#" class="clear btn btn-danger "> Clear</a>
              </div>
            </div>
          </div>  -->


          <div class="row">
          @if(count($users) > 0)
            <div class="col-sm-12 overflowbox table_formate_stayle_font">
              <table id="client_management_table" class="table table-striped table-bordered text-nowrap dataTable no-footer" role="grid" aria-describedby="zero_config_info">
                <thead>
                  <tr role="row" class="subHeaderTable">
                    <th class="sorting_asc text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-sort="ascending" aria-label="SN: activate to sort column descending" style="width: 0px;">SN</th>
                    <th class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 0px;">Company Name</th>
                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Company Phone</th>
                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Company Address</th>
                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Client Name</th>
                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Client Phone</th>
                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Client email</th>
                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Status</th>
                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
            <tr role="row" class="odd" class="">
              <td class="sorting_1">{{$sn++}}</td>
              <td><a href="{{route('backend.client.view', [Crypt::encrypt($user->id)])}}" data-id="{{Crypt::encrypt($user->id)}}">{{$user->GetCompanyDetail?->name}}</a></td>
              <td>{{$user->GetCompanyDetail?->phone}}</td>
              <td>{{$user->GetCompanyDetail?->address}}</td>
              <td>{{$user->name}}</td>
              <td>{{$user->phone}}</td>
              <td>{{$user->email}}</td>
              <td>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="status" style="width:40px" data-id="{{$user->id}}" {{$user->deleted_at == null ? "checked" : ""}}>
              </div>
              </td>
              <td>
              <div class="delete_icon">
              <div class="d-flex gap-3" style="max-width: 100px;">
              <span>
                <a href="{{route('backend.client.view', [Crypt::encrypt($user->id)])}}" data-id="{{Crypt::encrypt($user->id)}}"><i class="ri-eye-line"></i></a>
              </span>
                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                <span>
                <a href="{{route('backend.client.edit', [Crypt::encrypt($user->id)])}}" class="editcolor"><i class="ri-pencil-line"></i></a>
                </span> 
              @endif 
              </div>
            </div>
            </td>
          </tr>
          @endforeach
            </tbody>
          </table>
        </div>
        @else
                <center><h3>No Record Available</h3></center>
            @endif
      </div>
    </div>
  </div> 

@section('javascript_section')
@if(Session::has('created'))
  <script>
      Swal.fire({
          title: "Success!",
          text: "{{Session::get('created')}}",
          icon: "success"
      });
  </script>
  @elseif(Session::has('updated'))
  <script>
      Swal.fire({
          title: "Success!",
          text: "{{Session::get('updated')}}",
          icon: "success"
      });
  </script> 
@endif

<script>
  $(document).on("change", "#status", async function(){
    const checkbox = this;
    const isActive = checkbox.checked;
    const status_value = isActive ? '1':'0';
    const status_text = isActive ? 'Active':'Inactive';
    const user_id = $(this).data('id');
    let url = "{{route('backend.client.change_employee')}}";

    Swal.fire({
      title: "Are you sure?",
      text: `You want to ${status_text} this user !`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes"
    }).then(async (result) => {
      if (result.isConfirmed){
        let response = await fetch(`${url}?status_value=${status_value}&user_id=${user_id}`);
        let responseData = await response.json(); 
        Swal.fire({
          title: "Success!",
          text: "User status has been updated.",
          icon: "success"
        }).then((result) => {
          window.location.reload();
        });
      }else if(result.isDismissed){
        window.location.reload();
      }
    });
  });

 
            $(document).ready(function() {
            $('#client_management_table').DataTable();
        });
      
</script>
 



@endsection
@endsection