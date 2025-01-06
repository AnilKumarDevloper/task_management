@extends('layouts/backend/main')
@section('main_section') 
<div class="page-titles">
          <div class="row">
            <div class="col-lg-8 col-md-6 col-12 align-self-center"> 
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li> 
                    <li class="breadcrumb-item" aria-current="page"><a href="" class="link">Client Folders</a></li>
                </ol>
              </nav> 
              <h3 class="mb-0 fw-bold">Client Folders</h3>
            </div> 
          </div>
        </div>
        <div class="container-fluid">
          <div class="row" id="addFolderHere">
          @if(count($main_folder_list) > 0)
          @foreach($main_folder_list as $m_folder)
            <div class="col-lg-2">
              <div class="folder_page">
                <div class="folder_icon">
                  <a href="{{route('backend.year_folder.index', [Crypt::encrypt($m_folder->id)])}}"><i class="fas fa-folder"></i></a>
                  <h5>{{$m_folder->label}}</h5>
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
       
          <!-- Modal Add Category -->
          <div class="modal none-border" id="add-new-event">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                  <h4 class="modal-title"><strong>Add</strong> Your Folder</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="row">
                      <div class="col-md-12">
                        <label class="control-label">Folder Name</label>
                        <input class="form-control form-white" placeholder="Enter name" type="text" id="folder_create" />
                      </div>
      
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="
                            btn btn-primary
                            waves-effect waves-light
                            save-category
                          " data-bs-dismiss="modal" onclick="addFolder()">
                    Add Folder
                  </button>
      
                </div>
              </div>
            </div>
          </div>
          <!-- END MODAL -->
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
    $(document).on("click", "#destroy_btn", async function(){
        let id = $(this).data('id');  
        const url = "{{ route('backend.employee.destroy', ':id') }}"; 
        let finalUrl = url.replace(':id', id); 
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }); 
        if (result.isConfirmed) {
            try { 
                const response = await fetch(finalUrl, {
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                        'Content-Type': 'application/json'
                    }
                }); 
                const responseData = await response.json(); 
                if (responseData.status === "success") {
                    await Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                } else { 
                    await Swal.fire({
                        title: "Error!",
                        text: "There was a problem deleting the file.",
                        icon: "error"
                    });
                }
            } catch (error) { 
                await Swal.fire({
                    title: "Error!",
                    text: "Something went wrong!",
                    icon: "error"
                });
                console.error('Error:', error);
            }
        }
    });
</script>

 
    


@endsection



@endsection