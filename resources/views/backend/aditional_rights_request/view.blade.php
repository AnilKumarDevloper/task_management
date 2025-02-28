@extends('layouts/backend/main')
@section('main_section') 
<style>
  .card-body{
    padding:13px 30px !important;
  }
</style>

<div class="page-titles pb-0">
    <div class="row">
        <div class="col-lg-8 col-md-6 col-12 align-self-center">
        <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li>
                  @if(Auth::user()->role_id == 4)
                   <li class="breadcrumb-item"><a href="{{route('backend.ticket.index')}}" class="link">Ticket Portal</a></li>
                  @else
                  <li class="breadcrumb-item"><a href="{{route('backend.additional_rights_request.index')}}" class="link">Additional Rights Request</a></li>
                  @endif
                  <li class="breadcrumb-item" aria-current="page">Request Detail</li>
                 </ol>
            </nav>
            <h3 class="mb-0 fw-bold">Request Detail</h3>
        </div> 
    </div>
</div>

<div class="container-fluid"> 
          <div class="row">
            <div class="col-lg-8">
              <div class="card opacityClass">
                <div class="card-body">
                  <h4 class="card-title">Reason</h4>
                  {{$right_req->reason ?? ''}}
                </div>
              </div>
              <div class="card opacityClass">
              <div class="card-body">
                  @if(count($comments) > 0)
            <h4 class="card-title">Ticket Replies</h4>
            <ul class="list-unstyled mt-5"> 
            @foreach($comments as $comment)
        @if($comment->getUser?->role_id == 1)
        <li class="d-flex align-items-start" >
          @if($comment->getUser?->profile != '')
          <img class="me-3" src="{{url($comment->getUser?->profile)}}"  alt="{{$comment->getUser?->name ?? ''}}" style="width:60px; height:60px; border-radius: 50%;"/>
          @else
          <img class="me-3" src="{{url('assets/backend/images/users/user.png')}}" alt="Generic placeholder image" style="width:60px; height:60px; border-radius: 50%;"/>
          @endif

          <div style="background: #6580b8; padding: 15px 5px 15px 15px; max-width: 550px; color: #fff; border-radius: 20px;">
          <div class="media-body">
          <h5 class="mt-0 mb-1" style="font-weight: 600; color:#fff;">{{$comment->getUser?->name ?? ''}}</h5>
          {{$comment->comment ?? ""}}
          </div>
          <p style="color: #2f2b2b; text-align: right; margin-right: 10px;">{{Carbon\Carbon::parse($comment->created_at)->format('d M, Y h:i A')}}</p>
          </div>  
        </li>
        @else
      <li class="gap-2 justify-content-end d-flex"> 
      <div class="d-flex align-items-start flex-row-reverse" > 
      @if($comment->getUser?->profile != '')
        <img class="me-3" src="{{url($comment->getUser?->profile)}}" alt="Generic placeholder image" style="width:60px; height:60px; border-radius: 50%;"/>
        @else
      <img class="me-3" src="{{url('assets/backend/images/users/user.png')}}"  alt="{{$comment->getUser?->name ?? ''}}" style="width:60px; height:60px; border-radius: 50%;"/>
    @endif 
      <div class="me-3" style="background: #501cd2; padding: 15px 15px 15px 15px; max-width: 550px; color: #fff; border-radius: 20px;">
      <div class="media-body">
        <h5 class="mt-0 mb-1" style="font-weight: 600; color:#fff;">{{$comment->getUser?->name ?? ''}}</h5>
        {{$comment->comment ?? ""}}
        </div>
        <p style="color: #ababab; text-align: right; margin-right: 10px;">{{Carbon\Carbon::parse($comment->created_at)->format('d M, Y h:i A')}}</p>
        </div> 
        </div>  
      </li>
    @endif
        <!-- <hr/> -->
         <br>
      @endforeach 
            <!-- <hr/> -->
            </ul>
          @else
                  <h4 class="card-title">No Replies</h4>

                  @endif
                </div>
              </div>
              <div class="card opacityClass">
              
                <div class="card-body">
                  <h4 class="mb-3">Write a reply</h4>
                  <form method="POST" action="{{route('backend.additional_rights_request.comment')}}">
                    @csrf
                    <input type="hidden" value="{{Crypt::encrypt($right_req->id)}}" name="request_id" id="request_id">
                    <textarea id="comment" name="comment" class="w-100" rows="5" required></textarea>
                    @error('comment')
                      <p style="color:red;">{{$message}}</p>
                    @enderror
                    <button type="submit" class="mt-3 btn waves-effect waves-light btn-success">
                      Reply
                    </button>
                  </form>
                </div>  
 
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card opacityClass">
                <div class="card-body">
                  <h4 class="card-title mb-0">Ticket Info</h4>
                </div>
                <div class="card-body bg-light">
                  <div class="row text-center">
                    <div class="col-6 my-2 text-start" id="request_status"> 
                    @if($right_req->resolution_status == 1)
                    <b class="badge bg-warning">Pending</b> 
                    @elseif($right_req->resolution_status == 2) 
                    <b class="badge bg-success">Accepted</b>
                    @elseif($right_req->resolution_status == 3)
                    <b class="badge bg-danger" >Denied</b>
                    @endif 
                    </div>
                    <div class="col-6 my-2">{{Carbon\Carbon::parse($right_req->created_at)->format('d M, Y')}}</div>
                  </div>
                </div>
                @if(Auth::user()->role_id == 1)
                <div class="card-body">
                  <h5 class="pt-3">Update Current Status</h5>
                  <select class="form-control" name="current_status" id="current_status" style="background: white;">
                    <option value="1" {{$right_req->resolution_status == 1 ? 'selected' : ''}}>Pending</option> 
                    <option value="2" {{$right_req->resolution_status == 2 ? 'selected' : ''}}>Accepted</option> 
                    <option value="3" {{$right_req->resolution_status == 3 ? 'selected' : ''}}>Denied</option> 
                  </select> 
                </div>
                @endif

                <div class="card-body">
                  <h5 class="pt-3">Request Number</h5>
                  <span>{{$right_req->request_number ?? ''}}</span>
                </div>
                <div class="card-body">
                  <h5 class="pt-3">Attachment</h5>

                    @if($right_req->file != '')
                  <a href="{{route('backend.additional_rights_request.view_ticket_doc', [Crypt::encrypt($right_req->file)])}}">{{$right_req->original_file_name}}</a>
                  @else
                  <span>Not Available</span>
                  @endif  

                </div>
                  @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                 <div class="card-body">
                  <h5 class="pt-3">Authority Matrix</h5>
                  <a href="{{route('backend.authority_matrix.rights', [Crypt::encrypt($right_req->getRaisedBy?->id)])}}">View Rights</a>
                </div>
                @endif  
                

              </div>
              <div class="card opacityClass" style="overflow: hidden;">
                <div class="card-body text-center">
                  <h4 class="card-title">Client Info</h4>
                  <div class=""> 
                  @if($right_req->getRaisedBy?->profile != '')
                    <img src="{{url($right_req->getRaisedBy?->profile)}}" width="150" class="rounded-circle" alt="user" />
                    @else
                    <img src="{{url('assets/backend/images/users/user.png')}}" width="150" class="rounded-circle" alt="user" />
                    @endif
                   
                    <h4 class="mt-3 mb-0">{{$right_req->getRaisedBy?->name}}</h4>
                    <a href="javascript:void(0)">{{$right_req->getRaisedBy?->email}}</a>
                  </div>
                  <div class="row text-center mt-5">
                    <div class="col-6">
                      <h3 class="fw-bold">{{$total_request_count ?? '0'}}</h3>
                      <h6>Total</h6>
                    </div>
                    <div class="col-6">
                      <h3 class="fw-bold">{{$pending_request_count ?? '0'}}</h3>
                      <h6>Pending</h6>
                    </div>
                    <hr />
                    <div class="col-6">
                      <h3 class="fw-bold">{{$accepted_request_count ?? '0'}}</h3>
                      <h6>Accepted</h6>
                    </div>
                    <div class="col-6">
                      <h3 class="fw-bold">{{$denied_request_count ?? '0'}}</h3>
                      <h6>Denied</h6>
                    </div>
                  </div>
                </div> 
              </div> 
            </div>
          </div>
        </div> 
@section('javascript_section') 
 @if(Session::has('posted'))
    <script>
      Swal.fire({
      title: "Success",
      text: "{{Session::get('posted')}}",
      icon: "success"
    });
    </script>
 @endif

 <script>
  $(document).on("change", "#current_status", async function(){
    let request_id = $("#request_id").val();
    let current_status = $("#current_status").val();
    console.log(request_id);
    let url = "{{route('backend.additional_rights_request.update_current_status')}}";
    let response = await fetch(`${url}?request_id=${request_id}&current_status=${current_status}`);
    let responseData = await response.json();
    console.log(responseData);
    if(responseData.status == "success"){
        if(current_status == 1){
          $("#request_status").html(`<b class="badge bg-warning">Pending</b>`);
        }else if(current_status == 2){
          $("#request_status").html(`<b class="badge bg-success">Accepted</b>`);
        }else if(current_status == 3){
          $("#request_status").html(`<b class="badge bg-danger">Denied</b>`);
        }
        Swal.fire({
          title: "Success",
          text: "Ticket status has been updated successfully.",
          icon: "success"
        });
    }
  });
 </script>

@endsection 
@endsection