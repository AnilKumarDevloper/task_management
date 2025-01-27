@extends('layouts/backend/main')
@section('main_section')  
    <div class="page-ti" style="padding: 20px 30px 10px 30px;">
    <div class="row">
            <div class="col-lg-8 col-md-6 col-12 align-self-center"> 
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item"><a href="" class="link"><i class="ri-home-3-line fs-5"></i></a></li> 
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.task.index')}}" class="link">Task Management</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0)" class="link">Assign Task</a></li>
                </ol>
            </nav>
              <h3 class="mt-3 mb-0 fw-bold text-white">Assign Task</h3> 
            </div> 
          </div>    
    </div> 
    <div class="container-fluid"> 
        <div class="card opacityClass" style="overflow: hidden">
                <div class="max_width" style="padding:10px 30px; border: 1px solid gainsboro;">
                    <form action="{{ route('backend.task.store_from_task_list') }}" method="POST" enctype='multipart/form-data'>
                        @csrf
                        <div class="row lable_font">
                
                            <div class="col-md-4 mt-4">
                                <label class="control-label">Compliance</label>
                                <input type="text" class="form-control" name="title" placeholder="Compliance" maxlength="50">
                                @error('title')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                
                            <div class="col-md-4 mt-4">
                                <label class="control-label">Select Client</label>
                                <select class="form-control" name="client" id="client" style="background: white;" required>
                                    <option value="">--Select--</option>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}">{{$client->getCompanyDetail->name}}</option>
                                    @endforeach
                                </select>
                                @error('client')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                
                            <!-- <div class="col-md-4 mt-4">
                                <label class="control-label">Employee Name</label>
                                <input type="text" class="form-control" id="employee_name" disabled>
                            </div> -->
                
                            <div class="col-md-4 mt-4">
                                <label class="control-label">Select Employee</label>
                                <select class="form-control" name="employee" id="employee" style="background: white;" required>
                                    <option value="">--Select--</option>
                                </select>
                                @error('employee')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 mt-4">
                                <label class="control-label">Select Financial Year</label>
                                <select class="form-control" name="year" style="background: white;" required>
                                    <option value="">--Select--</option>
                                    @foreach($financial_years as $year)
                                        <option value="{{$year->name}}">{{$year->name}}</option>
                                    @endforeach
                                </select>
                                @error('year')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 mt-4">
                                <label class="control-label">Select month</label>
                                <select class="form-control" name="month" style="background: white;" required>
                                    <option value="">--Select--</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                                @error('month')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 mt-4">
                                <label class="control-label">Start Date</label>
                                <input type="date" class="form-control form-white" name="start_date" id="start_date" required>
                                @error('start_date')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 mt-4">
                                <label class="control-label">Due Date</label>
                                <input type="date" class="form-control form-white" name="due_date" id="due_date" required>
                                @error('due_date')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                
                
                            <div class="col-md-4 mt-4">
                                <label class="control-label">Compliance Date</label>
                                <input type="date" class="form-control form-white" name="compliance_date" id="compliance_date">
                                @error('compliance_date')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                
                            <div class="col-md-4 mt-3 ">
                                <label class="control-label">Description</label>
                                <textarea placeholder="Describe task..." class="form-control" name="description"
                                    maxlength="300"></textarea>
                                @error('description')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                
                            <div class="col-md-4 mt-3">
                                <label class="control-label"> Upload File</label>
                                <input type="file" name="document[]" id="document" class="form-control"
                                    accept=".jpg, .jpeg, .pdf, .png, .doc, .docx, .xls, .xlsx, .xlsm, .txt" multiple>
                                @error('document')
                                    <p style="color:red;">{{ $message }}</p>
                                @enderror
                            </div>
                
                            <div class="col-12 mt-4 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary waves-effect waves-light save-category">
                                    Create Task
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
                $("#employee").empty(); 
                let client_id = $(this).val(); 
                let url = "{{route('api.get_employee')}}";  
                let response = await fetch(`${url}?client_id=${client_id}`);
                let responseData = await response.json();
                console.log(responseData);
                responseData.employee.forEach(element => {
                    $("#employee").append(`<option value="${element.id}">${element.name}</option>`); 
                });
                // $("#employee_name").val(responseData.employee.name);
            });


        // $(document).on("change", "#employee", async function(){
        //     $("#client").empty();
        //     // $("#main_folder").append(`<option value="">--Select--</option>`)
        //     let employee_id = $(this).val();
        //     let url = "{{route('api.get_client_list')}}";  
        //     let response = await fetch(`${url}?employee_id=${employee_id}`);
        //     let responseData = await response.json(); 
        //     $("#client_name").val(responseData.clients[0].name);
        //     responseData.clients.forEach(element=>{
        //         $("#client").append(`<option value="${element.id}">${element.name}</option>`);
        //     });
        // });
 


        
        // $(document).on("change", "#main_folder", async function(){
        //     $("#year_folder").empty();
        //     $("#month_folder").empty();
        //     $("#year_folder").append(`<option value="">--Select--</option`);
        //     $("#month_folder").append(`<option value="">--Select--</option>`);
        //     let client_id = $("#main_folder").val();
        //     let url = "{{route('api.get_year_folder_list')}}";
        //     let response = await fetch(`${url}?client_id=${client_id}`);
        //     let responseData = await response.json(); 
        //     responseData.year_folders.forEach((element, index) => {
        //         const isSelected = index === responseData.year_folders.length - 1 ? 'selected' : '';
        //             $("#year_folder").append(`<option value="${element.id}" ${isSelected}>${element.name}</option>`);
        //         });
        //     responseData.month_folders.forEach(element => {
        //         $("#month_folder").append(`<option value="${element.id}" ${responseData.current_month == element.name ? "selected":""}>${element.name}</option>`);
        //     });
        // });

        // $(document).on("change", "#year_folder", async function(){
        //     let year_id = $(this).val();
        //     $("#month_folder").empty();
        //     $("#month_folder").append(`<option value="">--Select--</option>`);
        //     let url = "{{route('api.get_month_folder_list')}}";
        //     let response = await fetch(`${url}?year_folder_id=${year_id}`);
        //     let responseData = await response.json(); 
        //     responseData.month_folders.forEach(element => {
        //         $("#month_folder").append(`<option value="${element.id}">${element.name}</option>`);
        //     });
        // })

        // $(document).on("change", "#month_folder", async function(){
        //     $("#document").empty();
        //     $("#document").append(`<option value="">--Select--</option>`);
        //     let month_folder_id = $(this).val();
        //     console.log(month_folder_id);
        //     let url = "{{route('api.get_document_list')}}";
        //     let response = await fetch(`${url}?month_folder=${month_folder_id}`);
        //     let responseData = await response.json();
        //     console.log(responseData);
        //     responseData.document_list.forEach(element => {
        //         $("#document").append(`<option value="${element.id}">${element.title ?? 'No Title'}</option>`);
        //     });
        // });


        document.addEventListener("DOMContentLoaded", function () {
            const startDateInput = document.getElementById("start_date");
            const endDateInput = document.getElementById("due_date"); 
            const today = new Date().toISOString().split("T")[0];
            startDateInput.setAttribute("min", today); 
            endDateInput.disabled = true; 
            startDateInput.addEventListener("change", function () {
                if (startDateInput.value) { 
                    endDateInput.disabled = false; 
                    endDateInput.setAttribute("min", startDateInput.value);
                } else { 
                    endDateInput.disabled = true;
                    endDateInput.value = "";
                }
            });
        });
 
    </script>
@endsection


@endsection
