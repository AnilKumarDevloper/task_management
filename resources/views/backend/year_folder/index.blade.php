@extends('layouts/backend/main')
@section('main_section') 
<div class="page-titles">
          <div class="row">
            <div class="col-lg-8 col-md-6 col-12 align-self-center"> 
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li> 
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.main_folder.index')}}" class="link">Client Folders</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="" class="link">{{$main_folder_label}}</a></li>
                </ol>
            </nav>
              <h3 class="mb-0 fw-bold">Client Folder > {{$main_folder_label}}</h3>
            </div>
            <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
              <a href="#" data-bs-toggle="modal" data-bs-target="#add-new-event" class="btn d-flex align-items-center justify-content-center d-block w-100 btn-info waves-effect waves-light">
                <i class="ri-add-line fs-6 me-2"></i> Add folder
              </a>
            </div>
          </div>
        </div>
        <div class="container-fluid">
          <div class="row" id="addFolderHere"> 

          @if(count($year_folder_list) > 0)
          @foreach($year_folder_list as $y_folder)
            <div class="col-lg-2">
              <div class="folder_page">
                <div class="folder_icon">
                  <a href="{{route('backend.month_folder.index', [Crypt::encrypt($decrypt_main_f_id), Crypt::encrypt($y_folder->id)])}}"><i class="fas fa-folder"></i></a>
                  <h5>{{$y_folder->label ?? ''}}</h5>
                </div>
                <div class="three_dot" id="edit_file">
                  <div class="dropdown">
                    <button class="btn btn-link" type="button" id="threeDotsMenu" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="threeDotsMenu" style="">
                      <li><a class="dropdown-item" href="">Permissions</a></li>
                      <li><a class="dropdown-item" href="Add_document.html">Upload File</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div> 
            @endforeach
            @else
            <h1>No Folder Available</h1>
            @endif 
          </div>
           
          <div class="modal none-border" id="add-new-event">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header d-flex align-items-center" id="modalHeader">
                  <h4 class="modal-title">Add Your Folder</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{route('backend.year_folder.store')}}">

                <div class="modal-body">
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <label class="control-label">Folder Name</label>
                        <select name="folder_name" class="form-control form-white">
                          <option value="">Select Year</option>
                          @foreach($year_folder_name as $year)
                            <option value="{{$year}}">{{$year}}</option>
                          @endforeach
                        </select> 
                        <input type="hidden" value="{{$decrypt_main_f_id}}" name="m_f_id">
                      </div> 
                    </div>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary waves-effect waves-light save-category">
                    Add Folder
                  </button>
                </div>

                </form>
              </div>
            </div>
          </div>
          <!-- END MODAL -->
        </div> 

@section('javascript_section')
  @if(Session::has('created'))
    <script>
      Swal.fire({
      title: "Success",
      text: "{{Session::get('created')}}",
      icon: "success"
    });
    </script> 
    @elseif(Session::has('already_exists'))

    <script>
      Swal.fire({
      title: "Warning",
      text: "{{Session::get('already_exists')}}",
      icon: "warning"
    });
    </script>
  @endif

@endsection 
@endsection