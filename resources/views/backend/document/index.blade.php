@extends('layouts/backend/main')
@section('main_section') 
<div class="page-titles">
          <div class="row">
            <div class="col-lg-8 col-md-6 col-12 align-self-center"> 
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item"><a href="" class="link"><i class="ri-home-3-line fs-5"></i></a></li> 
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.main_folder.index')}}" class="link">Client Folders</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.year_folder.index', [Crypt::encrypt($main_folder->id)])}}" class="link">{{$main_folder->label}}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.month_folder.index', [Crypt::encrypt($main_folder->id), Crypt::encrypt($year_folder->id)])}}" class="link">{{$year_folder->label}}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="" class="link">{{$month_folder->label}}</a></li>
                </ol>
            </nav>
              <h3 class="mb-0 fw-bold">All Documents</h3> 
            </div>
            <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
              <a href="#" data-bs-toggle="modal" data-bs-target="#add-new-event" class="btn d-flex align-items-center justify-content-center d-block w-100 btn-info waves-effect waves-light">
                <i class="ri-add-line fs-6 me-2"></i> Upload
              </a>
            </div>
          </div>
        </div>
        <div class="container-fluid">
          <div class="row" id="addFolderHere"> 
            <div class="col-md-12">
            @error('title')
                 <p style="color:red">{{ $message }}</p>
            @enderror
            @error('document')
                 <p style="color:red">{{ $message }}</p>
            @enderror
            @error('start_date')
                 <p style="color:red">{{ $message }}</p>
            @enderror
            @error('end_date')
                 <p style="color:red">{{ $message }}</p>
            @enderror
            @error('employee')
                 <p style="color:red">{{ $message }}</p>
            @enderror
            </div>

            @if(count($documents) != 0)
          <table id="zero_config" class="table table-striped table-bordered text-nowrap dataTable no-footer"
                role="grid" aria-describedby="zero_config_info">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1"
                            aria-sort="ascending" aria-label="SN: activate to sort column descending"
                            style="width: 0px;">SN
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1"
                            aria-label="Department Name: activate to sort column ascending" style="width: 0px;">
                            Title</th> 
                        <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1"
                            aria-label="Department Name: activate to sort column ascending" style="width: 0px;">
                            File Type</th> 
                        <th style="width: 0px;" class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1"
                            colspan="1" aria-label="Action: activate to sort column ascending">Action</th>
                    </tr>
                </thead>
                <tbody> 
                    @php
                    $sn = 1;
                    @endphp
                    @foreach($documents as $doc)
                    <tr role="row" class="odd"> 
                        <td class="sorting_1">{{$sn++}}</td>
                        <td><a href="">{{$doc->title ?? 'No Title'}}</a></td> 
                        <td>{{ strtoupper(pathinfo($doc->doc_file, PATHINFO_EXTENSION)) }}</td>
                        <td>
                            <div class="delete_icon"> 
                                <div class="d-flex gap-3" style="max-width: 100px;"> 
                                <span>
                                <a href="javascript:void(0)" data-doc_id="{{$doc->id}}" id="edit_btn" title="Edit"><i class="ri-pencil-line"></i></a> 
                                </span>
                                <span>
                                <a href="javascript:void(0)" data-doc_id="{{$doc->id}}" id="destroy_btn" title="Delete"><i class="ri-delete-bin-5-line"></i></a>
                                </span>   
                                <span>
                                <a href="javascript:void(0)" data-doc_id="{{$doc->id}}" id="assign_btn" title="Assign Task"><i class="ri-user-add-line"></i></a>
                                </span>
                                </div>
                            </div>
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
            </table> 
            {{$documents->links('pagination::bootstrap-5')}} 
            @else
                    <center><h3>No Documents Found</h3></center>
            @endif
          </div> 
        </div> 

        <div class="modal none-border" id="add-new-event">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header d-flex align-items-center" id="modalHeader">
                  <h4 class="modal-title">Add New File</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <form method="POST" action="{{route('backend.document.store')}}" enctype="multipart/form-data"> 
                <div class="modal-body">
                    @csrf
                    <div class="row">
                    <div class="col-md-12">
                        <label class="control-label">Title</label> 
                        <input type="text" class="form-control form-white" name="title" placeholder="Document Title">  
                      </div> 
               
                      <div class="col-md-12">
                        <br>
                        <label class="control-label">Select File</label>
                        <input type="file" class="form-control form-white" name="document" required> 
                        <input type="hidden" value="{{$main_folder->id}}" name="main_f_id"> 
                        <input type="hidden" value="{{$year_folder->id}}" name="year_f_id">
                        <input type="hidden" value="{{$month_folder->id}}" name="month_f_id">
                      </div> 
                    </div>
                </div> 
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary waves-effect waves-light save-category">
                    Upload
                  </button>
                </div> 
                </form>
              </div>
            </div>
        </div>
 
          <div class="modal none-border" id="edit_document_modal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header d-flex align-items-center" id="modalHeader">
                  <h4 class="modal-title">Edit Document</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <form method="POST" action="{{route('backend.document.update')}}" enctype="multipart/form-data"> 
                <div class="modal-body">
                    @csrf
                    <div class="row">
                    <div class="col-md-12">
                        <label class="control-label">Title</label> 
                        <input type="text" class="form-control form-white" name="title" placeholder="Document Title">  
                      </div>  
                      <div class="col-md-12">
                        <br>     
                        <label class="control-label">Upload File To Replace </label>
                        <input type="file" class="form-control form-white" name="document"> 
                        <input type="hidden" name="doc_id">  
                        <input type="hidden" value="{{$main_folder->id}}" name="main_f_id"> 
                        <input type="hidden" value="{{$year_folder->id}}" name="year_f_id">
                        <input type="hidden" value="{{$month_folder->id}}" name="month_f_id">
                      </div> 
                    </div>
                </div> 
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary waves-effect waves-light save-category">
                    Update
                  </button>
                </div> 
                </form>
              </div>
            </div>
          </div>
 
          <div class="modal none-border" id="assign_task">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header d-flex align-items-center" id="modalHeader">
                  <h4 class="modal-title">Assign Task</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <form method="POST" action="{{route('backend.task.store')}}"> 
                <div class="modal-body">
                    @csrf
                    <div class="row">
                    <div class="col-md-12" style="border: 1px solid #ecf0f2; padding: 15px;">
                         <p id="document_title">This is Title</p>
                      </div>  
                      <div class="col-md-12">
                          <br>     
                          <label class="control-label">Start Date</label>
                          <input type="date" class="form-control form-white" name="start_date" id="start_date"> 
                      </div> 
                      <div class="col-md-12">
                          <br>     
                          <label class="control-label">End Date</label>
                          <input type="date" class="form-control form-white" name="end_date" id="end_date" disabled> 
                      </div> 
                      <div class="col-md-12">
                          <br>     
                          <label class="control-label">Select Employee</label>
                          <select class="form-control" name="employee">
                          <option value="">Select</option>
                          @foreach($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->name ?? ''}}</option>
                          @endforeach
                         </select>
                      </div>  
                      <div class="col-md-12">   
                        <input type="hidden" name="doc_id">  
                        <input type="hidden" value="{{$main_folder->id}}" name="main_f_id"> 
                        <input type="hidden" value="{{$year_folder->id}}" name="year_f_id">
                        <input type="hidden" value="{{$month_folder->id}}" name="month_f_id">
                      </div> 
                    </div>
                </div> 
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary waves-effect waves-light save-category">
                    Assign
                  </button>
                </div> 
                </form>
              </div>
            </div>
          </div>

    @section('javascript_section') 
        <script>
            const startDateInput = document.getElementById("start_date");
            const endDateInput = document.getElementById("end_date");
            const today = new Date().toISOString().split('T')[0];
            startDateInput.setAttribute("min", today);
            startDateInput.addEventListener("change", function() {
                if (startDateInput.value) {
                    endDateInput.setAttribute("min", startDateInput.value);
                    endDateInput.removeAttribute("disabled");
                } else {
                    endDateInput.value = '';
                    endDateInput.setAttribute("disabled", true);
                }
            }); 

            $(document).on("click", "#edit_btn", async function(){
                let doc_id = $(this).data('doc_id'); 
                let url = "{{route('backend.document.get_document')}}";
                let response = await fetch(`${url}?doc_id=${doc_id}`);
                let responseData = await response.json();
                if(responseData.status == "success"){ 
                    $("input[name='title']").val(responseData.document.title);  
                    $("input[name='doc_id']").val(doc_id);  
                    $('#edit_document_modal').modal('show');
                }else{
                    alert('Something went wrong.');
                }
            })

            $(document).on("click", "#destroy_btn", async function(){
                let doc_id = $(this).data('doc_id');
                let url = "{{route('backend.document.destroy')}}";
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
                        let response = await fetch(`${url}?doc_id=${doc_id}`);
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

            $(document).on("click", "#assign_btn", async function(){
                let doc_id = $(this).data('doc_id'); 
                let url = "{{route('backend.document.get_document')}}";
                let response = await fetch(`${url}?doc_id=${doc_id}`);
                let responseData = await response.json();
                if(responseData.status == "success"){  
                    $("#document_title").text(responseData.document.title ?? 'No Title')
                    $("input[name='doc_id']").val(doc_id);  
                    $('#assign_task').modal('show');
                }else{
                    alert('Something went wrong.');
                }
            }); 
        </script>
 
        @if(Session::has('created'))
            <script>
                Swal.fire({
                    title: "Success",
                    text: "{{Session::get('created')}}",
                    icon: "success"
                });
            </script>
        @elseif(Session::has('updated'))
            <script>
                Swal.fire({
                    title: "Success",
                    text: "{{Session::get('updated')}}",
                    icon: "success"
                });
            </script> 
        @elseif(Session::has('task_created'))
            <script>
                Swal.fire({
                    title: "Success",
                    text: "{{Session::get('task_created')}}",
                    icon: "success"
                });
            </script> 
        @endif
    @endsection  
    @endsection