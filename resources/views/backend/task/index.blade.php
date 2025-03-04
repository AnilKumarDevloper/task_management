@extends('layouts/backend/main')
@section('main_section')
<style>
  td {
    text-wrap: nowrap;
  }
</style>
<div class="page-titles pb-0">
    <div class="row">
        <div class="col-lg-8 col-md-6 col-12 align-self-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item"><a href="" class="link"><i class="ri-home-3-line fs-5"></i></a></li>
                    <li class="breadcrumb-item" aria-current="page">
                      <a href="javascript:void(0)" class="link">Task Management</a>
                    </li>
                </ol>
            </nav>
            <h3 class="mb-0 fw-bold">Task Management</h3>
        </div>
        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
          <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
              <a href="{{route('backend.task.assign')}}"
                  class="btn d-flex align-items-center justify-content-center d-block w-100 btn-info waves-effect waves-light">
                  <i class="ri-add-line fs-6 me-2"></i> New Task </a>
          </div>
        @endif
    </div>
</div> 
<div class="container-fluid">
  <div class="card opacityClass" style="border-radius: 10px;  padding: 20px"> 
    <div class="row" id="addFolderHere">
      <div class="col-md-12"> 
        @if(count($tasks) > 0) 
        <div class="accordion" id="client">  
          @foreach($tasks as $client => $years)
            <div class="accordion-item"> 
              <h2 class="accordion-header">
                <button class="accordion-button accordin_btn" type="button" data-bs-toggle="{{Auth::user()->role_id == 4 ? '':'collapse'}}" data-bs-target="#client_{{$client}}" aria-expanded="true" aria-controls="collapseOne">
                  @php $client_name = App\Models\User::withTrashed()->where('id', $client)->first()->name;
                  $company_name = App\Models\Backend\CompanyDetail::where('user_id', $client)->first()->name;
                  $total_task = App\Models\Backend\Task::where('client_id', $client)->count();
                   @endphp
                   @if(Auth::user()->role_id == 4)
                    All Task
                    @else
                  <!-- {{$client_name}} -->
                  {{$company_name}} 
                  @endif
                </button>
              </h2>
              <div id="client_{{$client}}" class="accordion-collapse collapse {{Auth::user()->role_id == 4 ? 'show':''}}" data-bs-parent="#client">  
                <div class="accordion-body">
                  <div class="accordion" id="year_{{$client}}">
                    @foreach($years as $year => $months)
                      <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button accordin_btn" type="button" data-bs-toggle="collapse" data-bs-target="#client_{{$client}}_{{$year}}" aria-expanded="true" aria-controls="collapseOne">
                            {{$year}}
                          </button>
                        </h2>
                        <div id="client_{{$client}}_{{$year}}" class="accordion-collapse collapse " data-bs-parent="#year_{{$client}}">
                          <div class="accordion-body">
                            <div class="accordion" id="client_{{$client}}_{{$year}}_month"> 
                              @foreach ($months as $month => $clientTasks)
                                <div class="accordion-item">
                                  <h2 class="accordion-header">
                                    <button class="accordion-button accordin_btn" type="button" data-bs-toggle="collapse" data-bs-target="#client_{{$client}}_{{$year}}_{{$month}}" aria-expanded="true" aria-controls="collapseOne">
                                      {{$month}}
                                    </button>
                                  </h2>
                                  <div id="client_{{$client}}_{{$year}}_{{$month}}" class="accordion-collapse collapse " data-bs-parent="#client_{{$client}}_{{$year}}_month">
                                    <div class="accordion-body">
                                      <div class="table_formate_stayle table-responsive">
                                      @php
                                        $view = App\Models\Backend\AuthorityMatrix::where('user_id', Auth::user()->id)->where('permission', 'view')->exists();
                                        $edit = App\Models\Backend\AuthorityMatrix::where('user_id', Auth::user()->id)->where('permission', 'edit')->exists();
                                        $delete = App\Models\Backend\AuthorityMatrix::where('user_id', Auth::user()->id)->where('permission', 'delete')->exists();
                                      @endphp

                                        <table class="table border">
                                          <thead>
                                            <tr>
                                              <th>SN</th>
                                              <th>Month</th>
                                              <th style="min-width:150px;">Compliance</th>
                                              <th>Status</th>
                                              <th>Due Date</th>
                                              <th>Compliance Date</th> 
                                              <th>Responsibility</th>
                                              <th style="min-width:370px;">Edit Trail</th>
                                              <th width="120px">Reminder</th>

                                              @if(Auth::user()->role_id == 4)
                                                @if($view || $edit || $delete)
                                                  <th>Action</th>
                                                @endif
                                              @else
                                                <th>Action</th>
                                              @endif

                                            </tr>
                                          </thead>
                                          <tbody>
                                            @php $sn = 1; @endphp
                                            @foreach ($clientTasks as $taskIndex => $task)
                                              <tr id="task_no_{{$task->id}}" class="task_row">
                                                <td>{{$sn++}}</td>
                                                <td>{{$task->month}}</td>
                                                <td>{{Str::limit($task->title, 50)}}</td>
                                                <td>
                                                  @if($task->current_status == 'pending')
                                                    <b class="badge bg-danger">Pending</b> 
                                                  @elseif($task->current_status == 'inprocess')
                                                    <b class="badge bg-warning">In Process</b>
                                                  @else
                                                    <b class="badge bg-success">Completed</b>
                                                  @endif
                                                </td>
                                                <td>{{Carbon\Carbon::parse($task->due_date)->format('d M, Y') ?? "N/A"}}</td>
                                                <td>{{Carbon\Carbon::parse($task->compliance_date)->format('d M, Y') ?? 'N/A'}}</td>
                                                <td>{{$task->getEmployee->name}}</td>
                                                <td>- Entry Creation by {{$task->getAssignedBy->name}} on {{Carbon\Carbon::parse($task->created_at)->format('M d, Y, h:i A')}}<br>
                                                  @if($task->getAmendedBy != null) 
                                                  - Modified by {{$task->getAmendedBy?->name}} on {{Carbon\Carbon::parse($task->updated_at)->format('M d, Y, h:i A')}}<br></td>
                                                  @endif
                                                <td>
                                                  <span>
                                                    @if($task->reminder_count > 0) 
                                                      <a href="javascript:void(0)" title="Send Reminder" class="send_reminder_btn" id="reminder_btn_{{$task->id}}" data-id="{{$task->id}}">
                                                        {{$task->reminder_count}} Reminder Sent
                                                      </a>
                                                    @else
                                                      <a href="javascript:void(0)" title="Send Reminder" class="send_reminder_btn" id="reminder_btn_{{$task->id}}" data-id="{{$task->id}}">
                                                        Send Reminder
                                                      </a>
                                                    @endif
                                                  </span>
                                                </td>


                                                <td>
                                                  <div class="delete_icon action_icons">
                                                    <div class="d-flex gap-2" style="max-width: 70px;">
                                                      
                                                      @if(Auth::user()->role_id == 4)
                                                      @if($view)
                                                      <span><a href="{{route('backend.task.view', [Crypt::encrypt($task->id)])}}" title="View"><i class="ri-eye-line"></i></a></span>
                                                      @endif  
                                                      
                                                      @if($edit)
                                                      <span><a href="{{route('backend.task.edit', [Crypt::encrypt($task->id)])}}" title="Edit"><i class="ri-pencil-line"></i></a></span>
                                                      @endif

                                                      @if($delete)
                                                      <span><a href="javascript:void(0)" data-task_id="{{$task->id}}" title="Delete" id="delete_btn"><i class="ri-delete-bin-5-line"></i></a></span>
                                                      @endif

                                                      @else
                                                      <span><a href="{{route('backend.task.edit', [Crypt::encrypt($task->id)])}}" title="Edit"><i class="ri-pencil-line"></i></a></span>
                                                      <span><a href="{{route('backend.task.view', [Crypt::encrypt($task->id)])}}" title="View"><i class="ri-eye-line"></i></a></span>
                                                      <span><a href="javascript:void(0)" data-task_id="{{$task->id}}" title="Delete" id="delete_btn"><i class="ri-delete-bin-5-line"></i></a></span>
                                                      @endif 
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
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div> 
              </div>
            </div>
          @endforeach 
        </div>
      @else
        <center><h3>No Record Available</h3></center>
        @endif 
      </div>
    </div>
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
  $(document).on("click", "#delete_btn", async function() {
      const task_id = $(this).data('task_id');
      const url = "{{route('backend.task.destroy')}}";
      Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
      }).then(async (result) => {
          if (result.isConfirmed) {
              let response = await fetch(`${url}?task_id=${task_id}`);
              let responseData = await response.json();
              if (responseData.status == "success") {
                  $("#task_no_" + task_id).remove();
                  Swal.fire({
                      title: "Deleted!",
                      text: "Task has been deleted successfully.",
                      icon: "success"
                  });
              }
          }  
      });
  }); 
  $(document).on('click', ".send_reminder_btn", async function() {
      let url = '{{route('backend.task.send_reminder')}}';
      let task_id = $(this).data('id');
      Swal.fire({
          title: "Are you sure?",
          text: "You want to send reminder?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, send!"
      }).then(async (result) => {
          if (result.isConfirmed) {
              $("#reminder_btn_" + task_id).text('Sending...');
              let response = await fetch(`${url}?task_id=${task_id}`);
              let responseData = await response.json();
              if (responseData.status == 'success') {
                  $("#reminder_btn_" + task_id).text(responseData.reminder_count +
                      ' Reminder Sent');
                  Swal.fire({
                      title: "Success!",
                      text: "Reminder sent successfully!",
                      icon: "success"
                  });
              } else {
                  alert('Something went wrong.');
              }

          }
      });
  });
</script> 
@endsection 
@endsection