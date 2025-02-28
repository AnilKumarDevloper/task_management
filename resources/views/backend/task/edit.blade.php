@extends('layouts/backend/main')
@section('main_section') 
<div class="page-titles">
          <div class="row">
            <div class="col-lg-8 col-md-6 col-12 align-self-center"> 
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item"><a href="" class="link"><i class="ri-home-3-line fs-5"></i></a></li> 
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.task.index')}}" class="link">Task Management</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0)" class="link">Edit Task</a></li>
                </ol>
            </nav>
              <h3 class="mt-3 mb-0 fw-bold">Edit Task</h3> 
            </div> 
          </div>
        </div>

    <div class="container-fluid"> 
        <div class="card opacityClass" style="overflow: hidden;">
                <div class="max_width" style="padding:10px 30px; border: 1px solid gainsboro;">
                    <form action="{{ route('backend.task.update', [$task->id]) }}" method="POST" enctype='multipart/form-data'>
                        @csrf
                        <div class="row lable_font">
                            <div class="col-md-4 mt-4">
                                <label class="control-label">Compliance</label>
                                <input type="text" class="form-control" name="title" value="{{$task->title ?? ''}}"
                                    placeholder="Compliance" maxlength="50" {{Auth::user()->role_id == 4 ? "disabled" : ""}} required>
                                @error('title')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                
                            <div class="col-md-4 mt-4">
                                <label class="control-label">Select Company</label>
                                <select class="form-control" name="client" id="client" style="background: white;" required
                                    {{Auth::user()->role_id == 4 ? "disabled" : ""}}>
                                    <!-- <option value="">--Select--</option>  -->
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}" {{$task->client_id == $client->id ? "selected" : ""}}>{{$client->getCompanyDetail->name}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-4 mt-4">
                                <label class="control-label">Select Employee</label>
                                <select class="form-control" name="employee" id="employee" style="background: white;" required>
                                @if(Auth::user()->role_id == 1)   
                                <option value="">--Select--</option>
                                @endif
                                    @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ $employee->id == $task->assigned_to ? "selected":"" }}>{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                                @error('employee')  
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>


                
                            <!-- <div class="col-md-4 mt-4">
                                <label class="control-label">Employee Name</label>
                                <input type="text" class="form-control" id="employee_name" value="{{$task->getEmployee?->name}}"
                                    disabled {{Auth::user()->role_id == 4 ? "disabled" : ""}} required>
                            </div> -->
                
                            <!-- <div class="col-md-4 mt-4" style="display:none;">
                                <label class="control-label">Select Employee</label>
                                <select class="form-control" name="employee" id="employee" style="background: white;"
                                    {{Auth::user()->role_id == 4 ? "disabled" : ""}} required>
                                    <option value="{{$task->getEmployee?->id}}">{{$task->getEmployee?->name}}</option>
                                </select>
                                @error('client')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div> -->
                            <div class="col-md-4 mt-4">
                                <label class="control-label">Select Financial Year</label>
                                <select class="form-control" name="year" style="background: white;" required {{Auth::user()->role_id == 4 ? "disabled" : ""}}>
                                    <option value="">--Select--</option>
                                    @foreach($financial_years as $year)
                                        <option value="{{$year->name}}" {{$year->name == $task->year ? 'selected' : ''}}>{{$year->name}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('year')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 mt-4" {{Auth::user()->role_id == 4 ? "disabled" : ""}}>
                                <label class="control-label">Select month</label>
                                <select class="form-control" name="month" style="background: white;" required>
                                    <option value="">--Select--</option>
                                    <option value="January" {{$task->month == 'January' ? 'selected' : ''}}>January</option>
                                    <option value="February" {{$task->month == 'February' ? 'selected' : ''}}>February</option>
                                    <option value="March" {{$task->month == 'March' ? 'selected' : ''}}>March</option>
                                    <option value="April" {{$task->month == 'April' ? 'selected' : ''}}>April</option>
                                    <option value="May" {{$task->month == 'May' ? 'selected' : ''}}>May</option>
                                    <option value="June" {{$task->month == 'June' ? 'selected' : ''}}>June</option>
                                    <option value="July" {{$task->month == 'July' ? 'selected' : ''}}>July</option>
                                    <option value="August" {{$task->month == 'August' ? 'selected' : ''}}>August</option>
                                    <option value="September" {{$task->month == 'September' ? 'selected' : ''}}>September</option>
                                    <option value="October" {{$task->month == 'October' ? 'selected' : ''}}>October</option>
                                    <option value="November" {{$task->month == 'November' ? 'selected' : ''}}>November</option>
                                    <option value="December" {{$task->month == 'December' ? 'selected' : ''}}>December</option>
                                </select>
                                @error('month')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 mt-4">
                                <label class="control-label">Start Date</label>
                                <input type="date" class="form-control form-white" name="start_date" id="start_date"
                                    value="{{Carbon\Carbon::parse($task->start_date)->format('Y-m-d')}}" {{Auth::user()->role_id == 4 ? "disabled" : ""}} required>
                                @error('start_date')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 mt-4">
                                <label class="control-label">Due Date</label>
                                <input type="date" class="form-control form-white" name="due_date" id="end_date"
                                    value="{{Carbon\Carbon::parse($task->due_date)->format('Y-m-d')}}" {{Auth::user()->role_id == 4 ? "disabled" : ""}} required>
                                @error('due_date')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 mt-4">
                                <label class="control-label">Compliance Date</label>
                                <input type="date" class="form-control form-white" name="compliance_date" id="compliance_date"
                                    value="{{$task->compliance_date != '' ? Carbon\Carbon::parse($task->compliance_date)->format('Y-m-d') : ''}}"
                                    {{Auth::user()->role_id == 4 ? "disabled" : ""}}>
                                @error('compliance_date')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                
                            <div class="col-md-4 mt-3">
                                <label class="control-label">Description</label>
                                <textarea placeholder="Describe task..." class="form-control" name="description" maxlength="300"
                                    {{Auth::user()->role_id == 4 ? "disabled" : ""}}>{{$task->description}}</textarea>
                                @error('description')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                
                            <div class="col-md-4 mt-3">
                                <lable>Select Current Status</lable>
                                <select name="current_status" style="width: 100%; height: 36px">
                                    <option value="pending" {{$task->current_status == "pending" ? "selected" : ""}}>Pending</option>
                                    <option value="inprocess" {{$task->current_status == "inprocess" ? "selected" : ""}}>In Process</option>
                                    <option value="completed" {{$task->current_status == "completed" ? "selected" : ""}}>Completed</option>
                                </select>
                            </div>
                
                            <div class="col-md-4 mt-3">
                                <label class="control-label"> Upload document file</label>
                                <input type="file" name="new_document[]" id="new_document" class="form-control"
                                    accept=".jpg, .jpeg, .pdf, .png, .doc, .docx, .xls, .xlsx, .xlsm, .txt" multiple>
                                @error('new_document')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="row">
                                @if(count($task->getTaskDocument) > 0)
                                    @foreach($task->getTaskDocument as $doc)
                                        <div class="col-md-4">
                                            <div class="inner_content d-flex justify-content-between my-2 p-2"
                                                style="background: #dce1ff; border-radius: 6px;" id="doc_{{$doc->id}}">
                                                <input type="hidden" value="{{$doc->id}}" name="documents[]">
                                                <a
                                                    href="{{route('backend.task.view_doc', [Crypt::encrypt($doc->id)])}}">{{$doc->file_original_name}}</a>
                                                <button type="button" class="btn-danger btn-sm"
                                                    onclick="removeDocument({{$doc->id}});">X</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-12 mt-4 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary waves-effect waves-light save-category">
                                    Update Task
                                </button>
                            </div>
                
                        </div>
                    </form>
                </div>
        </div>
    </div>
 
    @section('javascript_section')
    <script>
           $(document).on("change", "#client", async function(){
            let employees_html = '<option value="">--Select--</option>';
                $("#employee").empty();
                let client_id = $(this).val();
                let url = "{{route('api.get_employee')}}";
                let response = await fetch(`${url}?client_id=${client_id}`);
                let responseData = await response.json();
                responseData.employee.forEach(element => {
                    employees_html += `<option value="${element.id}">${element.name}</option>`;
                });
                $("#employee").append(employees_html);
            });

            document.addEventListener("DOMContentLoaded", function () {
            const startDateInput = document.getElementById("start_date");
            const endDateInput = document.getElementById("end_date"); 
            const complianceDateInput = document.getElementById("compliance_date");
            const start_date = startDateInput.value;
            const end_date = endDateInput.value;
            const compliance_date = complianceDateInput.value;
 
            const today = new Date().toISOString().split("T")[0];
            endDateInput.setAttribute("min", startDateInput.value);
            complianceDateInput.setAttribute("min", startDateInput.value);
            startDateInput.addEventListener("change", function () {
                if(startDateInput.value){
                    if(endDateInput.value && startDateInput.value > endDateInput.value){
                        endDateInput.value = "";
                    }
                    if(complianceDateInput.value && startDateInput.value > complianceDateInput.value){
                        complianceDateInput.value = "";
                    }
                    endDateInput.disabled = false; 
                    complianceDateInput.disabled = false; 
                    endDateInput.setAttribute("min", startDateInput.value);
                    complianceDateInput.setAttribute("min", startDateInput.value);
                }else{
                    endDateInput.disabled = true;
                    complianceDateInput.disabled = true; 
                    endDateInput.value = "";
                    complianceDateInput.value = "";
                }
            });
        });
    </script>
    @if(Session::has('task_updated')) 
        <script>
            Swal.fire({
                title: "Success",
                text: "{{Session::get('task_updated')}}",
                icon: "success"
            });
        </script>  
    @endif 

    <script>
        function removeDocument(doc_id){
            $("#doc_"+doc_id).remove();
        }
    </script>
    @endsection  
    @endsection