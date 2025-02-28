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
                  <li class="breadcrumb-item"><a href="{{route('backend.ticket.index')}}" class="link">Ticket Portal</a></li>
                  <li class="breadcrumb-item" aria-current="page">Ticket Detail</li>
                 </ol>
            </nav>
            <h3 class="mb-0 fw-bold">Ticket Detail</h3>
        </div> 
    </div>
</div>
<div class="container-fluid opacityClass"> 
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Ticket</h4>
          {{$ticket->question ?? ''}}
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          @if(count($comments) > 0)
          <h4 class="card-title">Ticket Replies</h4>
          <ul class="list-unstyled mt-5"> 
          @foreach($comments as $comment) 

        @if($comment->getUser?->id != Auth::user()->id)
      <li class="d-flex align-items-start" >
      @if($comment->getUser?->profile != '')
      <img class="me-3 " src="{{url($comment->getUser?->profile)}}"  alt="{{$comment->getUser?->name ?? ''}}"  style="width: 50px; height:50px; border-radius:50%;"/>
      @else
      <img class="me-3" src="{{url('assets/backend/images/users/user.png')}}" alt="Generic placeholder image" style="width: 50px; height:50px; border-radius:50%;"/>
      @endif 
      <div style="background: #6580b8; padding: 15px 5px 15px 15px; max-width: 550px; color: #fff; border-radius: 20px;">
      <div class="media-body">
      <h5 class="mt-0 mb-1" style="font-weight: 600; color:#fff;">{{$comment->getUser?->name ?? ''}}</h5>{{$comment->comment ?? ""}}</div>
      <p style="color: #2f2b2b; text-align: right; margin-right: 10px;">{{Carbon\Carbon::parse($comment->created_at)->format('d M, Y h:i A')}}</p>
      </div> 
      </li>
      @else
    <li class="gap-2 justify-content-end d-flex"> 
    <div class="d-flex align-items-start flex-row-reverse" > 
    @if($comment->getUser?->profile != '')
    <img class="me-3" src="{{url($comment->getUser?->profile)}}"  alt="Generic placeholder image"  style="width: 50px; height:50px; border-radius:50%;"/>
    @else
    <img class="me-3" src="{{url('assets/backend/images/users/user.png')}}" width="60" alt="{{$comment->getUser?->name ?? ''}}"  style="width: 50px; height:50px; border-radius:50%;"/>
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
        <br>
    @endforeach  
          </ul>
      @else
            <h4 class="card-title">No Replies</h4> 
          @endif
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <h4 class="mb-3">Write a reply</h4>
          <form method="POST" action="{{route('backend.ticket.comment')}}">
            <input type="hidden" value="{{Crypt::encrypt($ticket->id)}}" name="ticket_id" id="ticket_id">
            @csrf
            <textarea id="comment" name="comment" class="w-100" rows="5" required style="padding: 10px;" ></textarea>
            @error('comment')
              <p style="color:red;">{{$message}}</p>
            @enderror
            <button type="submit" class="mt-3 btn waves-effect waves-light btn-success">Reply</button> 
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
            <div class="col-6 my-2 text-start" id="ticket_status">
              @if($ticket->resolution_status == 1)
                <b class="badge bg-danger">Pending</b> 
              @elseif($ticket->resolution_status == 2) 
                <b class="badge bg-warning">In Progress</b>
              @elseif($ticket->resolution_status == 3)
                <b class="badge bg-success" >Closed</b>
              @endif 
            </div>
            <div class="col-6 my-2">{{Carbon\Carbon::parse($ticket->created_at)->format('M d, Y')}}</div>
          </div>
        </div>
        @if(Auth::user()->role_id == 1)
          <div class="card-body">
            <h5 class="pt-3">Update Current Status</h5>
            <select class="form-control" name="current_status" id="current_status" style="background: white;">
              <option value="1" {{$ticket->resolution_status == 1 ? 'selected' : ''}}>Pending</option> 
              <option value="2" {{$ticket->resolution_status == 2 ? 'selected' : ''}}>In Process</option> 
              <option value="3" {{$ticket->resolution_status == 3 ? 'selected' : ''}}>Closed</option> 
            </select> 
          </div>
        @endif
        <div class="card-body">
          <h5 class="pt-3">Ticket Number</h5>
          <span>{{$ticket->ticket_number ?? ''}}</span>
        </div>
        <div class="card-body">
          <h5 class="pt-3">Attachment</h5>
          @if($ticket->file != '')
            <a href="{{route('backend.ticket.view_ticket_doc', [Crypt::encrypt($ticket->file)])}}">{{$ticket->original_file_name}}</a>
          @else
            <span>Not Available</span>
          @endif
        </div> 
        <div class="card-body">
          <h5 class="pt-3">Reminder</h5>
          <a href="javascript:void(0);" title="Send Reminder" class="send_reminder_btn" id="reminder_btn_{{$ticket->id}}" data-id="{{$ticket->id}}">
            @if($ticket->reminder_status == 0)   
              Send Reminder
            @else
              {{$ticket->reminder_count}} Reminder Sent
            @endif
          </a>
        </div>
      </div>




      <div class="card opacityClass">
        <div class="card-body text-center">
          <h4 class="card-title">Client Info</h4>
          <div class="">
            @if($ticket->getRaisedBy?->profile != '')
              <img src="{{url($ticket->getRaisedBy?->profile)}}" width="150" class="rounded-circle" alt="user" />
            @else
              <img src="{{url('assets/backend/images/users/user.png')}}" width="150" class="rounded-circle" alt="user" />
            @endif
              <h4 class="mt-3 mb-0">{{$ticket->getRaisedBy?->name}}</h4>
              <a href="javascript:void(0)">{{$ticket->getRaisedBy?->email}}</a>
          </div>
          <div class="row text-center mt-5">
            <div class="col-6">
              <h3 class="fw-bold">{{$total_ticket_count ?? '0'}}</h3>
              <h6>Total</h6>
            </div>
            <div class="col-6">
              <h3 class="fw-bold">{{$pending_ticket_count ?? '0'}}</h3>
              <h6>Pending</h6>
            </div>
            <hr />
            <div class="col-6">
              <h3 class="fw-bold">{{$inprogress_ticket_count ?? '0'}}</h3>
              <h6>In Process</h6>
            </div>
            <div class="col-6">
              <h3 class="fw-bold">{{$close_ticket_count ?? '0'}}</h3>
              <h6>Closed</h6>
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
    let ticket_id = $("#ticket_id").val();
    let current_status = $("#current_status").val();
    let url = "{{route('backend.ticket.update_current_status')}}";
    let response = await fetch(`${url}?ticket_id=${ticket_id}&current_status=${current_status}`);
    let responseData = await response.json();
    console.log(responseData);
    if(responseData.status == "success"){
        if(current_status == 1){
          $("#ticket_status").html(`<b class="badge bg-danger">Pending</b>`);
        }else if(current_status ==2){
          $("#ticket_status").html(`<b class="badge bg-warning">In Process</b>`);
        }else if(current_status == 3){
          $("#ticket_status").html(`<b class="badge bg-success" >Closed</b>`);
        }
        Swal.fire({
          title: "Success",
          text: "Ticket status has been updated successfully.",
          icon: "success"
        });
    }
  });

  $(document).on("click", ".send_reminder_btn", async function(){
      let ticket_id = $(this).data('id'); 
      let url = "{{route('backend.ticket.send_reminder')}}"; 
      Swal.fire({
          title: "Are you sure?",
          text: "You want to send reminder?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Send!"
      }).then(async (result) => {
          if(result.isConfirmed) {
              $("#reminder_btn_"+ticket_id).text('Sending...');
              let response = await fetch(`${url}?ticket_id=${ticket_id}`);
              let responseData = await response.json(); 
              if(responseData.status == "success"){ 
                  Swal.fire({
                      title: "Success",
                      text: "Reminder sent successfully!",
                      icon: "success"
                  });
                  $("#reminder_btn_"+ticket_id).text(responseData.reminder_count + ' Reminder Sent');
              }else{
                  alert('Something went wrong.');
              }
          }
      }); 
  });
   
 </script>


@endsection

@endsection