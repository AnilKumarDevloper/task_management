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
                <!-- -year option code  is start --->
                <div class="accordion" id="year"> 
                @foreach($tasks as $year => $months)
                  <div class="accordion-item"> 
                  <h2 class="accordion-header">
                      <button class="accordion-button accordin_btn" type="button" data-bs-toggle="collapse" data-bs-target="#year_{{$year}}" aria-expanded="true" aria-controls="collapseOne">
                        {{$year}}
                      </button>
                    </h2>
                    <div id="year_{{$year}}" class="accordion-collapse collapse " data-bs-parent="#year">
                      <div class="accordion-body">
                        <div class="accordion" id="month_{{$year}}">

                        @foreach($months as $month => $clients)
                          <div class="accordion-item">
                            <h2 class="accordion-header">
                              <button class="accordion-button accordin_btn" type="button" data-bs-toggle="collapse" data-bs-target="#{{$month}}_{{$year}}" aria-expanded="true" aria-controls="collapseOne">
                                {{$month}}
                              </button>
                            </h2>
                          <div id="{{$month}}_{{$year}}" class="accordion-collapse collapse " data-bs-parent="#month_{{$year}}">
                            <div class="accordion-body">
                              <div class="accordion" id="client_{{$year}}_{{$month}}">

                              @foreach ($clients as $clientId => $clientTasks)
                                <div class="accordion-item">
                                  <h2 class="accordion-header">
                                    <button class="accordion-button accordin_btn" type="button" data-bs-toggle="collapse" data-bs-target="#client_{{$year}}_{{$month}}_{{$clientId}}" aria-expanded="true" aria-controls="collapseOne">
                                      {{$clientTasks[0]->getClient->name}}
                                    </button>
                                  </h2>
                                  <div id="client_{{$year}}_{{$month}}_{{$clientId}}" class="accordion-collapse collapse " data-bs-parent="#client_{{$year}}_{{$month}}">
                                    <div class="accordion-body">
                                      <div class="table_formate_stayle table-responsive">
                                        <table class="table border">
                                          <thead>
                                            <tr>
                                              <th>SN</th>
                                              <th>Month</th>
                                              <th style="min-width:150px;">Compliance</th>
                                              <th>Status</th>
                                              <th>Due Date</th>
                                              <th>Compliance Date</th>
                                              <th>Client</th>
                                              <th>Responsibility</th>
                                              <th style="min-width:370px;">Edit Trail</th>
                                              <th width="120px">Reminder</th>
                                              <th>Action</th>
                                            </tr>
                                          </thead>
                                        <tbody>
                                          @php $sn = 1; @endphp
                                        @foreach ($clientTasks as $taskIndex => $task)
                                          <tr id="task_no_{{$task->id}}" class="task_row">
                                            <td>{{$sn++}}</td>
                                            <td>{{$task->month}}</td>
                                            <td>{{Str::limit($task->description, 50)}}</td>
                                            <td>
                                            @if($task->current_status == 'pending')
                                                <b class="badge bg-danger">Pending</b> 
                                              @elseif($task->current_status == 'inprocess')
                                                <b class="badge bg-warning">Inprocess</b>
                                              @else
                                                <b class="badge bg-success">Completed</b>
                                              @endif
                                            </td>
                                            <td>{{Carbon\Carbon::parse($task->due_date)->format('d M, Y') ?? "N/A"}}</td>
                                            <td>{{Carbon\Carbon::parse($task->compliance_date)->format('d M, Y') ?? 'N/A'}}</td>
                                            <td>{{$task->getClient->name}}</td>
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
                                                  <span><a href="{{route('backend.task.edit', [Crypt::encrypt($task->id)])}}" title="Edit"><i class="ri-pencil-line"></i></a></span>
                                                  <span><a href="{{route('backend.task.view', [Crypt::encrypt($task->id)])}}" title="View"><i class="ri-eye-line"></i></a></span>
                                                  <span><a href="javascript:void(0)" data-task_id="{{$task->id}}" title="Delete" id="delete_btn"><i class="ri-delete-bin-5-line"></i></a></span>
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
                <!---year option code is end --->
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

 
<!--  ==============================================work with script================================================================= -->
<!-- <script>
const tableApi = async () => {
    const accordion_main = document.getElementById('accordion_main');
    const url = "{{route('api.get_task_list')}}";
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error("Browser can't reach the server.");
        }
        const responseData = await response.json();
        const responseDataTask = responseData.task_list;
        console.log(responseData);
        // Month names in chronological order
        const monthNames = [
            "January", "February", "March", "April", "May", "June", "July", "August", "September",
            "October", "November", "December"
        ];
        responseDataTask.forEach((element_year) => {
            const yearId = `year_${element_year.year}`;
            const headingId = `heading_${element_year.year}`;
            let monthContent = ''; // Reset for each year 

            // shorting month by month index
            element_year.month.sort((a, b) => {
                const monthIndexA = monthNames.indexOf(a.monthName);
                const monthIndexB = monthNames.indexOf(b.monthName);
                return monthIndexA - monthIndexB;
            })

            element_year.month.forEach((month_element) => {
                let tableRows = '';
                if (month_element.task && month_element.task.length > 0) {
                    month_element.task.forEach((task, index) => {
                        // Handle null or missing values for each task field
                        const doc_url =
                            `{{ route('backend.task.view_doc', ':doc_id') }}`.replace(
                                ':doc_id', task.enc_id);
                        const dueDate = task.due_date || 'N/A';
                        const complianceDate = task.compliance_date || 'N/A';
                        const documentLink = task.doc_path ? `${doc_url}` : '#';
                        const documentName = task.doc_file || 'No Document';
                        const assignedTo = task.get_employee ? task.get_employee.name :
                            'N/A';
                        const task_id = task.id;
                        const reminder = task.reminder_count === 0 ? "Send Reminder" :
                            "Reminder Sent";
                        const reminder_count = task.reminder_count || '';
                        const client = task.get_client ? task.get_client.name : 'N/A';

                        const reminder_status = task.reminder_status;
                        const assignedBy = task.get_assigned_by ? task.get_assigned_by
                            .name : 'N/A';
                        const ammendedBy = task.get_amended_by ? task.get_amended_by
                            .name : 'N/A';
                        const createdAt = new Date(task.created_at);
                        const updatedAt = new Date(task.updated_at);
                        const task_edit_url =
                            `{{route('backend.task.edit', ':task_id')}}`.replace(
                                ':task_id', task.enc_id);
                        const task_view_url =
                            `{{route('backend.task.view', ':task_id')}}`.replace(
                                ':task_id', task.enc_id);
                        const formattedCreatedDate = createdAt.toLocaleString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit',
                            // second: '2-digit',
                            hour12: true
                        });
                        const formattedUpdatedDate = updatedAt.toLocaleString('en-US', {
                            year: 'numeric',
                            month: 'short',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit',
                            // second: '2-digit',
                            hour12: true
                        });
                        let ammended_html = '';
                        if (task.get_amended_by) {
                            ammended_html =
                                `- Modified by ${ammendedBy} on ${formattedUpdatedDate}</span><br>`;
                        }
                        tableRows += `
              <tr id="task_no_${task.id}">
                <td>${index + 1}</td>
                <td>${task.month}</td>
               <td >${task.description?.length > 50 ? task.description.substring(0, 50) + '...' : task.description || 'N/A'}</td>
                
                 <td>`;
                        if (task.current_status == 'pending') {
                            tableRows += `<b class="badge bg-danger">Pending</b>`;
                        } else if (task.current_status == 'inprocess') {
                            tableRows += `<b class="badge bg-warning">Inprocess</b>`;
                        } else {
                            tableRows += `<b class="badge bg-success">Completed</b>`;
                        }
                        tableRows += `</td>
                <td>${dueDate}</td>
                <td>${complianceDate}</td>
                <td>${client}</td>
                <td>${assignedTo}</td>
                <td><span>- Entry Creation by ${assignedBy} on ${formattedCreatedDate}</span><br>
                  ${ammended_html}
                </td>`;
                        if (responseData.role_id != 3) {
                            tableRows += `<td>
                    <span>
                            <a href="javascript:void(0)" title="Send Reminder" class="send_reminder_btn" id="reminder_btn_${task_id}" data-id="${task_id}" >
                                ${reminder_count} ${reminder}
                            </a>
                    </span>
                </td>`;
                        }

                        tableRows += `<td>
                  <div class="delete_icon action_icons">
                    <div class="d-flex gap-2" style="max-width: 70px;">`;
                        if (responseData.role_id == 4) {
                            if (responseData.rights.includes('edit')) {
                                tableRows +=
                                    `<span><a href="${task_edit_url}" title="Edit"><i class="ri-pencil-line"></i></a></span>`;
                            }
                            if (responseData.rights.includes('view')) {
                                tableRows +=
                                    `<span><a href="${task_view_url}" title="View"><i class="ri-eye-line"></i></a></span>`;
                            }
                            if (responseData.rights.includes('delete')) {
                                tableRows +=
                                    ` <span><a href="javascript:void(0)" data-task_id="${task.id}" title="Delete" id=delete_btn><i class="ri-delete-bin-5-line"></i></a></span>`;
                            }
                        } else {
                            tableRows +=
                                `<span><a href="${task_edit_url}" title="Edit"><i class="ri-pencil-line"></i></a></span>
                      <span><a href="${task_view_url}" title="View"><i class="ri-eye-line"></i></a></span>
                      <span><a href="javascript:void(0)" data-task_id="${task.id}" title="Delete" id=delete_btn><i class="ri-delete-bin-5-line"></i></a></span>`;
                        }
                        tableRows += ` </div>
                  </div>
                </td>
              </tr>`;
                    });
                } else {
                    // If there are no tasks for this month, show a message
                    tableRows = `
            <tr>
              <td colspan="10" class="text-center">No tasks available for this month</td>
            </tr>`;
                }
                monthContent += `
          <div class="accordion-item mb-2">
            <h2 class="accordion-header" id="heading_${yearId}_${month_element.monthName}">
              <button class="accordion-button accordin_btn ansmonthColor" type="button" data-bs-toggle="collapse" data-bs-target="#${yearId}_${month_element.monthName}" aria-expanded="true" aria-controls="${yearId}_${month_element.monthName}">
                <b>${month_element.monthName}</b>
              </button>
            </h2>
            <div id="${yearId}_${month_element.monthName}" class="accordion-collapse collapse" aria-labelledby="heading_${yearId}_${month_element.monthName}" data-bs-parent="#accordionExample_months">
              <div class="accordion-body_padding">
                <div class="table_formate_stayle table-responsive">
                  <table class="table border" style="min-width: 1250px;">
                    <thead>
                      <tr>
                        <th>SN</th>
                        <th>Month</th>
                        <th style="min-width:150px;">Compliance</th>
                        <th>Status</th>
                        <th width="100px">Due Date</th>
                        <th width="130px">Compliance Date</th>
                         <th>Client</th>
                        <th>Responsibility</th>
                        <th style="min-width:370px;" >Edit Trail</th>`;
                if (responseData.role_id != 3) {
                    monthContent += `<th width="120px">Reminder</th>`;
                }
                monthContent += `<th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      ${tableRows}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>`;
            });
            // Add the year accordion section with the generated month content
            accordion_main.innerHTML += `
        <div class="accordion-item mb-2">
          <h2 class="accordion-header" id="${headingId}">
            <button class="accordion-button accordin_btn" type="button" data-bs-toggle="collapse" data-bs-target="#${yearId}" aria-expanded="true" aria-controls="${yearId}">
              <b>${element_year.year}</b>
            </button>
          </h2>
          <div id="${yearId}" class="accordion-collapse collapse" aria-labelledby="${headingId}" data-bs-parent="#accordionExample">
            <div class="accordion-body_padding">
              <div id="month_main_${yearId}">
                ${monthContent}
              </div>
            </div>
          </div>
        </div>`;
        });
    } catch (error) {
        console.error("This is a network error", error);
    }



};
tableApi();
</script> -->
@endsection 
@endsection