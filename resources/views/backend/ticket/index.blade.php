@extends('layouts/backend/main')
@section('main_section') 

<div class="page-titles pb-0">
    <div class="row">
        <div class="col-lg-8 col-md-6 col-12 align-self-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item "><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5 "></i></a></li>
                    <li class="breadcrumb-item" aria-current="page">All Tickets</li>
                </ol>
            </nav>
            <h3 class="mb-0 fw-bold text-white">Ticket Portal</h3>
        </div>
        @if(Auth::user()->role_id == 4)
            <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
                <a href="{{route('backend.ticket.create')}}" class="btn d-flex align-items-center justify-content-center d-block w-100 btn-info waves-effect waves-light"><i class="ri-add-line fs-6 me-2"></i> Raise a Ticket </a>
            </div>
        @endif 
    </div>
</div>
<div class="container-fluid"> 
    <div class="card opacityClass" style="border-radius: 10px;  padding: 20px">
 
          <!-- <div class="col-12 mb-3">
            <div class="form-group d-flex justify-content-end gap-1">
              <form method="GET" action="">
                <div class="d-flex gap-2">
                  <input type="text" class="form-control" id="" placeholder="Search here..."
                    style="border: 1px solid #54667a; min-width:280px;" name="" value="" aria-label="Search Title">
                  <button class="btn btn-info">Search</button>
                </div>
              </form>
              <div>
                <a href="#" class="clear btn btn-danger "> Clear</a>
              </div>
            </div>
          </div> -->
        
        <div class="row">
            <div class="col-sm-12 overflowbox table_formate_stayle_font">
                @if(count($tickets) > 0)
                    <table id="ticket_table" class="table table-striped table-bordered text-nowrap dataTable no-footer"role="grid" aria-describedby="zero_config_info">
                        <thead>
                            <tr role="row" class="subHeaderTable">
                                <th class="sorting_asc text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-sort="ascending" aria-label="SN: activate to sort column descending" style="width: 0px;">SN</th>
                                <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Ticket Number</th>
                                <th class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 0px;">Raised
                                    By</th>
                                <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config"
                                    rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Date of
                                    Ticket </th>
                                <th style="width: 10px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config"
                                    rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Question</th>
                                <th style="width: 10px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config"
                                    rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Resolution
                                    Date</th>
                                <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config"
                                    rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Resolution
                                    Status</th>

                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4)
                                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config"
                                    rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">
                                    Reminder</th>
                                    @endif 
                                <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config"
                                    rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $sn = 1; @endphp
                            @foreach($tickets as $ticket)
                                <tr role="row" class="odd">
                                    <td class="sorting_1">{{$sn++}}</td>
                                    <td><a href="{{route('backend.ticket.view', [Crypt::encrypt($ticket->id)])}}" title="View Ticket">{{$ticket->ticket_number ?? ""}}</a></td>
                                    <td>{{$ticket->getRaisedBy?->name}}</td>
                                    <td>{{Carbon\Carbon::parse($ticket->created_at)->format('d M, Y')}}</td>
                                    <td>{{Str::limit($ticket->question, 50)}}</td>
                                    <td>
                                        @if($ticket->resolution_date != '')
                                            {{Carbon\Carbon::parse($ticket->resolution_date)->format('d M, Y')}}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($ticket->resolution_status == 1)
                                            <b class="badge bg-danger">Pending</b>
                                        @elseif($ticket->resolution_status == 2) 
                                            <span class="badge bg-warning">In Progress</span>
                                        @elseif($ticket->resolution_status == 3)
                                            <b class="badge bg-success">Closed</b>
                                        @endif
                                    </td>
                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4)
                                    <td>
                                        <span>
                                            <a href="javascript:void(0);" title="Send Reminder" class="send_reminder_btn" id="reminder_btn_{{$ticket->id}}" data-id="{{$ticket->id}}">
                                                @if($ticket->reminder_status == 0)   
                                                    Send Reminder
                                                @else
                                                {{$ticket->reminder_count}} Reminder Sent
                                                @endif
                                            </a>
                                        </span> 
                                    </td>
                                    @endif
                                    <td>
                                        <div class="delete_icon">
                                            <div class="d-flex gap-3" style="max-width: 100px;">
                                            <span><a href="{{route('backend.ticket.view', [Crypt::encrypt($ticket->id)])}}" title="View Ticket"><i class="ri-eye-line"></i></a></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                @else
                    <p>No Ticket Found</p>
                @endif
            </div>
        </div>
          
    </div>
 
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
    @endif
    
    <script> 
          $(document).ready(function() {
            $('#ticket_table').DataTable();
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
                if (result.isConfirmed) {
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