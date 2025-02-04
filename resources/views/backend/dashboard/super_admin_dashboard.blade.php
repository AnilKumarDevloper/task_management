@extends('layouts/backend/main')
@section('main_section')
@php
    $view = App\Models\Backend\AuthorityMatrix::where('user_id', Auth::user()->id)->where('permission', 'view')->exists();
    $edit = App\Models\Backend\AuthorityMatrix::where('user_id', Auth::user()->id)->where('permission', 'edit')->exists();
    $delete = App\Models\Backend\AuthorityMatrix::where('user_id', Auth::user()->id)->where('permission', 'delete')->exists();
  @endphp
<div class="page-titles h-100" style="height:100vh">
    <div class="row">
        <div class="col-lg-8 col-md-6 col-12 align-self-center">
            <h1 class="mb-0 fw-bold">Dashboard</h1>
        </div>
        <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end"> 
        </div>
    </div>
     
    <div class="container-fluid">
        <div class="row opacityClass">
            <div class="col-lg-12">
                <div class="card-group">
                    <div class="card">
                        <div class="align-items-center card-body d-flex flex-column"> 
                            <a href="{{route('backend.task.index')}}">
                            <span class="btn btn-xl btn-light-info text-info btn-circle d-flex align-items-center justify-content-center">
                                <i class="mdi mdi-arrow-all"></i>
                            </span> 
                            </a>
                            <h3 class="mt-3 pt-1 mb-0">{{$all_task_count ?? '0'}}</h3>
                            <h6 class="text-muted mb-0 fw-normal">Total Task</h6>
                        </div>
                    </div>
                    <div class="card">
                        <div class="align-items-center card-body d-flex flex-column">
                        <a href="{{route('backend.task.index')}}?task_status=pending">
                            <span class="btn btn-xl btn-light-info text-info btn-circle d-flex align-items-center justify-content-center">
                            <i class="mdi mdi-open-in-new"></i>
                            </span>
                            </a>
                            <h3 class="mt-3 pt-1 mb-0">{{$pending_task_count ?? '0'}}</h3>
                            <h6 class="text-muted mb-0 fw-normal">Pending Task</h6>
                        </div>
                    </div>
                    <div class="card">
                        <div class="align-items-center card-body d-flex flex-column">
                        <a href="{{route('backend.task.index')}}?task_status=inprocess">
                            <span class="btn btn-xl btn-light-warning text-warning btn-circle d-flex align-items-center justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-package">
                                    <path d="M12.89 1.45l8 4A2 2 0 0 1 22 7.24v9.53a2 2 0 0 1-1.11 1.79l-8 4a2 2 0 0 1-1.79 0l-8-4a2 2 0 0 1-1.1-1.8V7.24a2 2 0 0 1 1.11-1.79l8-4a2 2 0 0 1 1.78 0z"></path>
                                    <polyline points="2.32 6.16 12 11 21.68 6.16"></polyline>
                                    <line x1="12" y1="22.76" x2="12" y2="11"></line>
                                    <line x1="7" y1="3.5" x2="17" y2="8.5"></line>
                                </svg>
                            </span>
                            </a>
                            <h3 class="mt-3 pt-1 mb-0">{{$inprocess_task_count ?? '0'}}</h3>
                            <h6 class="text-muted mb-0 fw-normal">In Process</h6>
                        </div>
                    </div>
                    <div class="card">
                        <div class="align-items-center card-body d-flex flex-column">
                        <a href="{{route('backend.task.index')}}?task_status=completed">
                            <span class="btn btn-xl btn-light-danger text-danger btn-circle d-flex align-items-center justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                                    <line x1="12" y1="20" x2="12" y2="10"></line>
                                    <line x1="18" y1="20" x2="18" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="16"></line>
                                </svg>
                            </span>
                            </a>
                            <h3 class="mt-3 pt-1 mb-0 d-flex align-items-center">{{$complete_task_count ?? '0'}}</h3>
                            <h6 class="text-muted mb-0 fw-normal">Completed</h6>
                        </div>
                    </div>
                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                    <div class="card">
                        <div class="align-items-center card-body d-flex flex-column">
                        <a href="{{route('backend.client.index')}}">
                            <span class="btn btn-xl btn-light-success text-success btn-circle d-flex align-items-center justify-content-center">
                            <i class="mdi mdi-account"></i>
                            </span>
                            </a>

                            <h3 class="mt-3 pt-1 mb-0">{{$total_client ?? '0'}}</h3>
                            <h6 class="text-muted mb-0 fw-normal">Total Clients</h6>
                        </div>
                    </div>

                    <div class="card">
                        <div class="align-items-center card-body d-flex flex-column">
                        <a href="{{route('backend.employee.index')}}">
                        <span class="btn btn-xl btn-light-success text-success btn-circle d-flex align-items-center justify-content-center">
                            <i class="mdi mdi-account"></i>
                            </span>
                            </a>

                            <h3 class="mt-3 pt-1 mb-0">{{$total_employee ?? '0'}}</h3>
                            <h6 class="text-muted mb-0 fw-normal">Total Employee</h6>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div> 

     <div class="card opacityClass" style="border-radius: 10px;  padding: 20px">
            <div class="row">
                <div class="col-sm-12 overflowbox table_formate_stayle_font">
                    <h2>Recent Added Task</h2>
                 
                    @if($recent_tasks != null && count($recent_tasks) > 0)
                        <table id="recent_task_table" class="table table-striped table-bordered text-nowrap dataTable no-footer" role="grid"
                            aria-describedby="zero_config_info">
                            <thead>
                                <tr role="row" class="subHeaderTable"  >
                                    <th class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1"
                                        aria-label="Department Name: activate to sort column ascending" style="width: 0px;">FY</th>
                                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                        colspan="1" aria-label="Action: activate to sort column ascending">Month</th>
                                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                        colspan="1" aria-label="Action: activate to sort column ascending">Compliance</th>
                                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                        colspan="1" aria-label="Action: activate to sort column ascending">Status</th>
                                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                        colspan="1" aria-label="Action: activate to sort column ascending">Due Date</th>
                                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                        colspan="1" aria-label="Action: activate to sort column ascending">Compliance Date</th>
                                    <!-- <th style="width: 0px;" class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Document</th> -->
                                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                        colspan="1" aria-label="Action: activate to sort column ascending">Company Name</th>
                                        <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                        colspan="1" aria-label="Action: activate to sort column ascending">Responsibility</th>
                                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                        colspan="1" aria-label="Action: activate to sort column ascending">Edit Trail</th>
                                        <th>
                                        @if(Auth::user()->role_id == 4)
                                                @if($view || $edit || $delete)
                                                 Action
                                                @endif
                                              @else
                                                Action
                                              @endif
                                              </th>
                                    </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_tasks as $task)
                                    <tr role="row" class="odd">
                                        <td>
                                            @if(Auth::user()->role_id == 4)
                                            @if($view)
                                                <span><a href="{{route('backend.task.view', [Crypt::encrypt($task->id)])}}" title="View">{{$task->year ?? ''}}</a></span>
                                            @else
                                                <span>{{$task->year ?? ''}}</span>
                                            @endif 
                                            
                                            @else
                                                <span><a href="{{route('backend.task.view', [Crypt::encrypt($task->id)])}}" title="View">{{$task->year ?? ''}}</a></span>
                                            @endif 
                                    </td>
                                        <td>{{$task->month ?? ''}}</td>
                                        <td>{{$task->title ?? 'No Title'}}</td>

                                        <td>
                                            @if($task->current_status == 'pending')
                                                <b class="badge bg-danger">Pending</b> 
                                            @elseif($task->current_status == 'inprocess')
                                                <b class="badge bg-warning">Inprocess</b>
                                            @else
                                                <b class="badge bg-success">Completed</b>
                                            @endif 
                                        </td>
 
                                        <td>{{Carbon\Carbon::parse($task->due_date)->format('d M, Y')}}</td>
                                        <td>{{Carbon\Carbon::parse($task->compliance_date)->format('d M, Y')}}</td>
                                        <!-- <td>
                                                    @if($task->doc_file != '')
                                                    <a href="{{route('backend.task.view_doc', [Crypt::encrypt($task->id)])}}">{{$task->doc_file}}</a>
                                                    @else
                                                    No Document Uploaded
                                                    @endif
                                                </td>  -->
                                        <!-- <td>{{$task->getClient?->name}}</td> -->
                                        <td>{{$task->getClient?->getCompanyDetail->name}}</td>
                                        <td>{{$task->getEmployee?->name}}</td>
                                        <td>
                                            <div class="dv">
                                                <span>- Entry Creation by {{$task->getAssignedBy?->name}} on
                                                    {{Carbon\Carbon::parse($task->created_at)->format('d M, Y h:i A')}}</span><br>
                                                @if($task->amended_by != '')
                                                    <span>- Modified by {{$task->getAmendedBy?->name}} on
                                                        {{Carbon\Carbon::parse($task->updated_at)->format('d M, Y h:i A')}}</span>
                                                @endif
                                            </div>
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
                        
                    @else
                        <p>No Task Available</p>
                    @endif
                </div>
            </div>
     </div>
    </div> 

    @section('javascript_section')
        <script>
            $(document).ready(function() {
            $('#recent_task_table').DataTable();
        });
        </script>
    @endsection
 

@endsection