@extends('layouts/backend/main')
@section('main_section') 
<div class="page-titles">
    <div class="row">
        <div class="col-lg-8 col-md-6 col-12 align-self-center"> 
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item"><a href="" class="link"><i class="ri-home-3-line fs-5"></i></a></li> 
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.employee.index')}}" class="link">Employee Management</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0)" class="link">Employee Detail</a></li>
                </ol>
            </nav>
            <h3 class="mb-0 fw-bold">Employee Detail</h3> 
        </div> 
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card opacityClass" style="overflow: hidden;">
                <div class="border-bottom title-part-padding d-flex justify-content-between">
                    <h4>Employee Detail</h4>
                </div>  
                <div class="container-fluid">
                    <div class="card opacityClass" style="overflow:hidden">
                        <div class="max_width" style="padding:10px 30px; border: 1px solid gainsboro;"> 
                                <div class="row lable_font"> 
                                <h5>Employee Profile</h5>
                                    <div class="col-md-4">
                                        <label class="control-label">Employee Name</label> <input class="form-control form-white input_border" name="user_name" placeholder="User Name" type="text" value="{{$user->name ?? ''}}" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">Employee Phone</label>
                                        <input class="form-control form-white input_border" name="phone" placeholder="User Phone" type="text" value="{{$user->phone ?? ''}}" disabled>
                                    </div>
                                    <div class="col-md-4 mb-5">
                                        <label class="control-label">Employee Email</label>
                                        <input class="form-control form-white input_border" name="email" placeholder="User Email" type="email" value="{{$user->email ?? ''}}" disabled>
                                    </div>  
                                    <hr>
                                    <div class="col-md-12 mt-4">
                                    <h5>Assigned Clients/Company</h5>
                                        @if($user->clients != '')
                                        <table id="zero_config" class="table table-striped table-bordered text-nowrap dataTable no-footer"
                                            role="grid" aria-describedby="zero_config_info">
                                            <thead>
                                                <tr role="row" class="subHeaderTable">
                                                    <th class="sorting_asc" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-sort="ascending" aria-label="SN: activate to sort column descending" style="width: 0px;">Company Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1" aria-label="Department Name: activate to sort column ascending" style="width: 0px;">Client Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $clients = App\Models\User::with('getCompanyDetail')->whereIn('id', $user->clients)->get();
                                            @endphp
                                            
                                            @foreach($clients as $index => $client)
                                            <tr>
                                                <td><a href="{{route('backend.client.view', [Crypt::encrypt($client->id)])}}">{{$client->getCompanyDetail->name}}</a></td>
                                                <td><a href="{{route('backend.client.view', [Crypt::encrypt($client->id)])}}">{{$client->name}}</a></td>
                                            </tr>
                                             
                                                @if($index != count($clients) - 1)
                                                
                                                @endif
                                            @endforeach 
                                            </tbody>
                                            </table>
                                            @else
                                            No Client Assigned
                                            @endif 
                                    </div> 
                                </div> 
                                <hr>
 
                    <div class="row mt-5">
                        <h5>Assigned Task Count</h5>
                        <div class="mb-3 col-md-6">
                            <div style="padding:5px 5px; border:1px solid gray">
                                 <a href="{{route('backend.task.index')}}?assigned_to={{$id}}">All Task:- <b class="text-dark">{{$total_count}}</b></a>
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <div style="padding:5px 5px; border:1px solid gray">
                                <a href="{{route('backend.task.index')}}?task_status=pending&assigned_to={{$id}}">Pending:- <b class="text-dark">{{$pending_count}}</b></a>
                            </div>
                        </div>  

                        <div class="col-md-6 mt-3">
                            <div style="padding:5px 5px; border:1px solid gray">
                                <a href="{{route('backend.task.index')}}?task_status=inprocess&assigned_to={{$id}}">In Process:-
                                    <b class="text-dark">{{$inprocess_count}}</b></a>
                            </div>
                        </div>  

                        <div class="col-md-6 mt-3">
                            <div style="padding:5px 5px; border:1px solid gray">
                                <a href="{{route('backend.task.index')}}?task_status=completed&assigned_to={{$id}}">Completed:- <b class="text-dark">{{$completed_count}}</b></a>
                            </div>
                        </div>
                         
                        <br>                   
                        <br> 
                    </div>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>  
</div>  
@section('javascript_section') 
 

@endsection  
@endsection