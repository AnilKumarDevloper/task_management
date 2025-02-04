@extends('layouts/backend/main')
@section('main_section') 

<div class="page-titles pb-0">
    <div class="row">
        <div class="col-lg-8 col-md-6 col-12 align-self-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item "><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5 "></i></a></li>
                    <li class="breadcrumb-item" aria-current="page">All Notification</li>
                </ol>
            </nav>
            <h3 class="mb-0 fw-bold text-white">All Notification</h3>
        </div> 
    </div>
</div>
<div class="container-fluid"> 
    <div class="card opacityClass" style="border-radius: 10px;  padding: 20px"> 
        <div class="row">
            <div class="col-sm-12 overflowbox table_formate_stayle_font">
            @if(count($notifications) > 0)
                    <table id="notification_table" class="table table-striped table-bordered text-nowrap dataTable no-footer"role="grid" aria-describedby="zero_config_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-sort="ascending" aria-label="SN: activate to sort column descending" style="width: 0px;">SN</th>
                                 <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Notification</th>
                                <th class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 0px;">Date</th>
                             </tr>
                        </thead>
                        <tbody>
                            @php $sn = 1; @endphp 
                            @foreach($notifications as $notification)
                                <tr role="row" class="odd">
                                    <td class="sorting_1">{{$sn++}}</td> 
                                    <td><a href="{{route('backend.notification.view', [$notification->id])}}" title="Notification">
                                    @if($notification->status == 1)    
                                    <i class="m-r-10 mdi mdi-email"></i>
                                    @elseif($notification->status == 2)
                                    <i class="m-r-10 mdi mdi-email-open"></i>
                                    @endif
                                    {{$notification->text}}</a></td>
                                    <td>{{Carbon\Carbon::parse($notification->created_at)->format('d M, Y')}}</td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>    
                     @else
                        <p>No Notification Found</p>
                    @endif 
            </div>
        </div> 
    </div> 
    </div>
@section('javascript_section')  
    <script>
        $(document).ready(function() {
            $('#notification_table').DataTable();
        });
    </script>
     
@endsection

@endsection