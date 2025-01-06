@extends('layouts/backend/main')
@section('main_section') 
  <div class="page-titles pb-0">
    <div class="row">
      <div class="col-lg-8 col-md-6 col-12 align-self-center"> 
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 d-flex align-items-center">
              <li class="breadcrumb-item"><a href="" class="link"><i class="ri-home-3-line fs-5"></i></a></li> 
              <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0)" class="link">Task Management</a></li>
          </ol>
        </nav>
        <h3 class="mb-0 fw-bold">Task Management</h3> 
      </div>
        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
          <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
            <a href="{{route('backend.task.assign')}}" class="btn d-flex align-items-center justify-content-center d-block w-100 btn-info waves-effect waves-light">
              <i class="ri-add-line fs-6 me-2"></i> New Task </a>
          </div>
        @endif
    </div>
  </div> 
  <form>
    <div class="page-titles pb-0 pt-0 mt-3">
      <div class="row">
        <div class="col-md-4">
          <div>
            <lable class="text-dark"><b>Select Financial Year</b></lable>
            <select class="form-select" aria-label="Default select example" name="financial_year" required>
              <option value="">--Select--</option>
              @foreach($financial_year as $fy)
              <option value="{{$fy->name}}" {{isset($_GET['financial_year']) && $_GET['financial_year'] == $fy->name ? "selected":""}}>{{$fy->name}}</option> 
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div>
            <lable class="text-dark"><b>Select Month</b></lable>
            <select class="form-select" aria-label="Default select example" name="month">
              <option value="">--Select--</option>
              <option value="January" {{isset($_GET['month']) && $_GET['month'] == 'January' ? "selected":""}}>January</option>
              <option value="February" {{isset($_GET['month']) && $_GET['month'] == 'February' ? "selected":""}}>February</option>
              <option value="March"{{isset($_GET['month']) && $_GET['month'] == 'March' ? "selected":""}} >March</option>
              <option value="April" {{isset($_GET['month']) && $_GET['month'] == 'April' ? "selected":""}} >April</option>
              <option value="May" {{isset($_GET['month']) && $_GET['month'] == 'May' ? "selected":""}} >May</option>
              <option value="June" {{isset($_GET['month']) && $_GET['month'] == 'June' ? "selected":""}} >June</option>
              <option value="July" {{isset($_GET['month']) && $_GET['month'] == 'July' ? "selected":""}} >July</option>
              <option value="August" {{isset($_GET['month']) && $_GET['month'] == 'August' ? "selected":""}} >August</option>
              <option value="September" {{isset($_GET['month']) && $_GET['month'] == 'September' ? "selected":""}} >September</option>
              <option value="October" {{isset($_GET['month']) && $_GET['month'] == 'October' ? "selected":""}} >October</option>
              <option value="November" {{isset($_GET['month']) && $_GET['month'] == 'November' ? "selected":""}} >November</option>
              <option value="December" {{isset($_GET['month']) && $_GET['month'] == 'Decembersky' ? "selected":""}} >December</option>
            </select>
          </div>
        </div>
        <div class="col-md-2 d-flex">
          <div class="mx-2" style="padding-top: 19px;">
            <button class="btn btn-primary">Search</button>
          </div>
          <div class="" style="padding-top: 19px;">
            <a href="{{route('backend.task.index')}}" class="btn btn-primary">Clear</a>
          </div>
        </div>
      </div>
    </div>
  </form>

  <div class="container-fluid">
    <div class="row" id="addFolderHere"> 
      <div class="col-md-12 overflowbox">
        @if(count($tasks) > 0)
          <table id="zero_config" class="table table-striped table-bordered text-nowrap dataTable no-footer" role="grid" aria-describedby="zero_config_info">
           
            <thead>
              <tr role="row">
                <th style="width: 0px;">SN</th>
                <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 0px;">Month</th> 
                <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 0px;">Compliance</th> 
                <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 0px;">Status</th>
                <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 0px;">Due Date</th>
                <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 0px;">Compliance Date</th>
                <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 0px;">Document</th>
                <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 0px;">Responsibility</th> 
                <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 0px;">Edit Trail</th>  
                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                <th style="width: 0px;" class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Action</th>
                @endif
              </tr>
            </thead>

            <tbody> 
              @php $sn = 1; @endphp
              @foreach($tasks as $task)
              <tr>
                <td>{{$sn++}}</td>
                <td>{{$task->month}}</td> 
                <td>{{$task->title ?? 'No Title'}}</td>
                <td>{{strtoupper($task->current_status) ?? ''}}</td> 
                <td>{{Carbon\Carbon::parse($task->end_date)->format('d M, Y')}}</td>
                <td>
                  @if($task->compliance_date != '')
                    {{Carbon\Carbon::parse($task->compliance_date)->format('d M, Y')}}
                  @else
                    --
                  @endif
                </td>
                <td>
                  @if($task?->doc_file != '') 
                    <a href="{{route('backend.task.view_doc', [Crypt::encrypt($task->id)])}}">{{$task?->doc_file ?? ''}}</a>
                  @else
                    No Document Uploaded
                  @endif
                </td>
                <td>{{$task?->getEmployee->name ?? ''}}</td> 
      
                <td>
                  <span>- Entry Creation by {{$task->getAssignedBy?->name}} on {{Carbon\Carbon::parse($task->created_at)->format('d M, Y h:i A')}}</span><br>
                  @if($task->amended_by != '')
                    <span>- Modified by {{$task->getAmendedBy?->name}} on {{Carbon\Carbon::parse($task->updated_at)->format('d M, Y h:i A')}}</span>
                  @endif
                </td>
        
                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                  <td>
                    <div class="delete_icon"> 
                      <div class="d-flex gap-3" style="max-width: 100px;">  
                        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                          <span>
                            <a href="{{route('backend.task.edit', [$task->id])}}" data-doc_id="" id="edit_btn" title="Edit"><i class="ri-pencil-line"></i></a> 
                          </span>
                          <span>
                                <a href="{{route('backend.task.view', [$task->id])}}" data-doc_id="" id="edit_btn" title="Edit"> <i class="ri-eye-line"></i></a> 
                                </span>
                                @endif
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                <span>
                                <a href="javascript:void(0)" data-task_id="{{$task->id}}" id="destroy_btn" title="Delete"><i class="ri-delete-bin-5-line"></i></a>
                                </span>
                                @endif  
                                </div>
                            </div>
                        </td>
                        @endif
                    </tr>                       
                   @endforeach 
                </tbody>
            </table> 

            {{$tasks->links("pagination::bootstrap-4")}}
            </div>
            @else
            <center><h3>No Task Found</h3></center>
            @endif
      </div>
 </div>

         

    @section('javascript_section') 
    @if(Session::has('assigned'))
    <script>
        Swal.fire({
            title: "Success!",
            text: "{{Session::get('assigned')}}",
            icon: "success"
        });
    </script>
    @endif

        <script>
            $(document).on("click", "#destroy_btn", async function(){
                let task_id = $(this).data('task_id');
                let url = "{{route('backend.task.destroy')}}";
                Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then(async (result) => {
                    if (result.isConfirmed){
                        let response = await fetch(`${url}?task_id=${task_id}`);
                        let responseData = await response.json();
                        if(responseData.status == "success"){
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            }).then(()=>{
                                window.location.reload();
                            });
                        }
                    }
                });
            });

            $(document).on("click", "#assign_task_btn", function(){
                $('#assign_task').modal('show');
            });

            $(document).on("change", "#employee", async function(){
                $("#client").empty();
                let employee_id = $(this).val(); 
                let url = "{{route('api.get_client_list')}}";
                let response = await fetch(`${url}?employee_id=${employee_id}`);
                let responseData = await response.json();
                $("#client").append(`<option value="">--Select--</option>`)
                if(responseData.status == "success"){  
                    responseData.clients.forEach(element => {
                        $("#client").append(`<option value="${element.id}">${element.name}</option>`)
                    }); 
                }
            });
 
            $(document).on("change", "#client", async function(){
              $("#year_folder").empty();
              $("#month_folder").empty();
              let client_id = $(this).val();
              let url = "{{route('api.get_year_folder_list')}}";
              let response = await fetch(`${url}?client_id=${client_id}`);
              let responseData = await response.json(); 
              $("#year_folder").append(`<option value="">--Select--</option>`);
              if(responseData.status == "success"){
                responseData.year_folders.forEach((element, index) => {
                  const isSelected = index === responseData.year_folders.length - 1 ? 'selected' : '';
                  $("#year_folder").append(`<option value="${element.id}" ${isSelected}>${element.name}</option>`);
                });
                responseData.month_folders.forEach(element => {
                  $("#month_folder").append(`<option value="${element.id}" ${responseData.current_month == element.name ? "selected":""}>${element.name}</option>`);
                });
              }
            }); 
            $(document).on("change", "#year_folder", async function(){
              $("#month_folder").empty();
              $("#month_folder").append(`<option value="">--Select--</option>`);
              let year_folder_id = $(this).val();
              let url = "{{route('api.get_month_folder_list')}}";
              let response = await fetch(`${url}?year_folder_id=${year_folder_id}`);
              let responseData = await response.json(); 
              responseData.month_folders.forEach(element => {
                  $("#month_folder").append(`<option value="${element.id}">${element.name}</option>`);
              });
            }); 
        </script> 
    @endsection  

    @endsection