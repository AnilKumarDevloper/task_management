@extends('layouts/backend/main')
@section('main_section')
<div class="page-titles">
    <div class="row">
        <div class="col-lg-8 col-md-6 col-12 align-self-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li>
                  <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0)" class="link">Employee Management</a></li>
                </ol>
            </nav>
            <h1 class="mb-0 fw-bold text-white">Employee Management</h1>
        </div>
        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
        <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
            <a href="{{route('backend.employee.create')}}" class="btn d-flex align-items-center justify-content-center d-block w-100 btn-info waves-effect waves-light"><i class="ri-add-line fs-6 me-2"></i> Add Employee</a>
        </div>
        @endif 
    </div>
</div>
<div class="container-fluid">
<div class="card opacityClass" style="border-radius: 10px;  padding: 20px">
    <!---search box --->
    <!-- <div class="col-12 mb-3">
        <div class="form-group d-flex justify-content-end gap-1">
           <form method="GET" action="{{route('backend.employee.index')}}"  >
                <div class="d-flex gap-2">
                    <input type="text" class="form-control" id="searchTitle" placeholder="Search here..." 
                        style="border: 1px solid #54667a; min-width:280px;" name="search"
                        value="{{ isset($_GET['search']) && $_GET['search'] != '' ? $_GET['search'] : '' }}" aria-label="Search Title">
                    <button class="btn btn-info">Search</button>
                </div>
           </form>
           <div>
                <a href="{{route('backend.employee.index')}}" class="clear btn btn-danger " > Clear</a>
           </div>
        </div>
    </div> -->
    <!---search box  end--->
    @php
     $sn = ($users->currentPage() - 1) * $users->perPage() + 1;
    @endphp

    <div class="row">
        <div class="col-sm-12 table_formate_stayle_font overflowbox">
            @php $sn = 1;
            @endphp
            <table id="zero_config" class="table table-striped table-bordered text-nowrap dataTable no-footer"
                role="grid" aria-describedby="zero_config_info">
                <thead>
                    <tr role="row" class="subHeaderTable">
                        <th class="sorting_asc" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-sort="ascending" aria-label="SN: activate to sort column descending" style="width: 0px;">SN</th>
                        <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 0px;">Name</th>
                        <th style="width: 0px;" class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Phone</th>
                        <th style="width: 0px;" class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending"> Email</th>
                        <th style="width: 0px;" class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending"> Client</th>
                        <th style="width: 0px;" class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending"> Total Task</th>
                        <th style="width:0px;" class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending"> Status</th>
                        <th style="width: 50px" class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr role="row" class="odd">
                        <td class="sorting_1">{{$sn++}}</td>
                        <td> <a href="{{route('backend.employee.view_employee_tasks', [Crypt::encrypt($user->id)])}}">{{$user->name}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            @if($user->clients != '')
                            @php
                            $clients = App\Models\User::whereIn('id', $user->clients)->get();
                            @endphp
                            @foreach($clients as $index => $client)
                                <a href="{{route('backend.client.view', [Crypt::encrypt($client->id)])}}">{{$client->name}}</a>
                                @if($index != count($clients)-1)
                                    |
                                @endif
                            @endforeach 
                            @else
                            No Client Assigned
                            @endif
                        </td>
                        <td>
                            @if(count($user->getEmployeeTask) > 0)
                                <a href="{{route('backend.employee.view_employee_tasks', [Crypt::encrypt($user->id)])}}">{{count($user->getEmployeeTask)}} Task</a>
                            @else
                            <p>No Task Assigned</p>
                            @endif
                        </td>

                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="status" style="width:40px"
                                    data-id="{{$user->id}}" {{$user->deleted_at == null ? 'checked' : ''}}>
                            </div>
                        </td>
                        <td>
                            <div class="delete_icon">
                                <div class="d-flex gap-3" style="max-width: 100px;">
                                    <span><a href="{{route('backend.employee.edit', [Crypt::encrypt($user->id)])}}"><i
                                                class="ri-pencil-line"></i></a></span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
 
        </div>
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
        const status_value = isActive ? 1 : 0;
        const status_text = isActive ? "Active":"Inactive";
        const user_id = $(this).data('id');
        const url = "{{route('backend.employee.change_status')}}";
        Swal.fire({
            title: "Are you sure?",
            text: `You want to ${status_text} this user!`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await fetch(`${url}?status_value=${status_value}&user_id=${user_id}`);
                const responseData = await response.json();
                if(responseData.status == "success"){
                    Swal.fire({
                        title: "Success!",
                        text: "User status has been updated successfully.",
                        icon: "success"
                    }).then((result)=>{
                        window.location.reload(); 
                    });
                }else if(responseData.status == 'permission_denied'){
                    Swal.fire({
                        title: "Warning!",
                        text: "Permission Denied.",
                        icon: "error"
                    });
                }else{
                    Swal.fire({
                        title: "Error!",
                        text: "Something went wrong.",
                        icon: "error"
                    });
                } 
            }else if (result.isDismissed) { 
                window.location.reload();
            }
        }); 
    });

    $(document).on("click", "#folder_permission", function(){
        let employee_id = $(this).data('id');
        $("#employee_id").val(employee_id);
        $("#client_select").modal('show'); 
    });

    // $(document).on("click", "#destroy_btn", async function (){
    //     let id = $(this).data('id');
    //     const url = "{{ route('backend.employee.destroy', ':id') }}";
    //     let finalUrl = url.replace(':id', id);
    //     const result = await Swal.fire({
    //         title: "Are you sure?",
    //         text: "You won't be able to revert this!",
    //         icon: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#3085d6",
    //         cancelButtonColor: "#d33",
    //         confirmButtonText: "Yes, delete it!"
    //     });
    //     if (result.isConfirmed){
    //         try{
    //             const response = await fetch(finalUrl, {
    //                 method: "DELETE",
    //                 headers: {
    //                     'X-CSRF-TOKEN': '{{ csrf_token() }}',
    //                     'Content-Type': 'application/json'
    //                 }
    //             });
    //             const responseData = await response.json();
    //             if (responseData.status === "success"){
    //                 await Swal.fire({
    //                     title: "Deleted!",
    //                     text: "Your file has been deleted.",
    //                     icon: "success"
    //                 });
    //             } else{
    //                 await Swal.fire({
    //                     title: "Error!",
    //                     text: "There was a problem deleting the file.",
    //                     icon: "error"
    //                 });
    //             }
    //         }catch (error){
    //             await Swal.fire({
    //                 title: "Error!",
    //                 text: "Something went wrong!",
    //                 icon: "error"
    //             });
    //             console.error('Error:', error);
    //         }
    //     }
    // });
</script> 

 
    <script>
  
    document.addEventListener("DOMContentLoaded", function(){
        const searchinput = document.getElementById('SearchTitle');
        const tableRow = document.querySelectorAll('#zero_config tbody tr');
        searchinput.addEventListener('input', function(){

            const searchText = searchinput.value.toLowerCase();
            tableRow.forEach(rows =>{
                const rowsText = rows.innerText.toLowerCase();
                if(rowsText.includes(searchText)){
                    rows.style.display = "";
                }else{
                    rows.style.display = "none";
                }
            });
        });
    });
</script>
 
<script>
   $(document).ready(function() {
            $('#zero_config').DataTable();
    });
</script>
 
 
@endsection 
@endsection