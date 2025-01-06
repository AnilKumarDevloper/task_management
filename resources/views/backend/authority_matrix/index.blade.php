@extends('layouts/backend/main')
@section('main_section') 

<div class="page-titles pb-0">
    <div class="row">
        <div class="col-lg-8 col-md-6 col-12 align-self-center">
        <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li>
                  <li class="breadcrumb-item" aria-current="page">Authority Matrix</li>
                 </ol>
            </nav>
            <h3 class="mb-0 fw-bold">Authority Matrix</h3>
        </div> 
    </div>
</div>

<div class="container-fluid"> 
      <div class="card_mainElement">
            <div class="card opacityClass" style="border-radius: 10px;  padding: 20px" >
                     <!---search box --->
                    <!-- <div class="col-12 mb-3">
                        <div class="form-group d-flex justify-content-end gap-1">
                          <form method="GET" action="">
                            <div class="d-flex gap-2">
                            <input type="text" class="form-control" id="" placeholder="Search here..."
                                style="border: 1px solid #54667a; min-width:280px;" name="" value="" aria-label="Search Title">
                            <button class="btn btn-info">Search</button>
                            </div>
                          </form>
                        <div><a href="#" class="clear btn btn-danger "> Clear</a></div>
                        </div>
                    </div> -->
                     <!---search box  end--->
                <div class="row">
                    <div class="col-sm-12 overflowbox table_formate_stayle_font">
                    
                    <table id="zero_config" class="table table-striped table-bordered text-nowrap dataTable no-footer" role="grid"
                            aria-describedby="zero_config_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1"
                                        aria-sort="ascending" aria-label="SN: activate to sort column descending" style="width: 0px;">SN
                                    </th>
                                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                    colspan="1" aria-label="Action: activate to sort column ascending">User Name</th>
                                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                    colspan="1" aria-label="Action: activate to sort column ascending">Authority Rights</th>
                                    <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                        colspan="1" aria-label="Action: activate to sort column ascending">Action</th>
                                </tr>
                            </thead>
                            <tbody> 
                                @php $sn = 1; @endphp
                                @if(count($clients) > 0)
                                    @foreach($clients as $client)
                                        <tr>
                                            <td>{{$sn++}}</td>
                                            <td>{{$client->name}}</td>
                                            <td> 
                                                @foreach($client->getAuthorityMatrix as $index => $right)
                                                    {{strtoupper($right->permission)}} 
                                                    @if($index != count($client->getAuthorityMatrix)-1)
                                                    |
                                                    @endif
                                                @endforeach 
                                            </td> 
                                            <td>
                                            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                                            <a href="{{route('backend.authority_matrix.rights', [Crypt::encrypt($client->id)])}}">Add/Remove Rights</a>   
                                            @endif
                                            @if(Auth::user()->role_id == 4)
                                            @if(count($client->getAuthorityMatrix) < 3)
                                            <a href="{{route('backend.additional_rights_request.create')}}">Request Additional Rights</a>
                                            @else
                                            <span>No Action Required</span>
                                            @endif
                                            @endif
                                        </td>
                                        </tr>
                                    @endforeach 
                                @endif
                            </tbody>
                        </table>
                       {{$clients->links("pagination::bootstrap-5")}}
                    </div>
                </div>
            </div>

             @if(Auth::user()->role_id == 4) 
             @if(count($right_requests) > 0) 
            <div class="card-body opacityClass bg-white" style="border-radius: 10px; paddding: 20px !important; ">  
                <div class="row">
                <h3 class="mb-1 fw-bold">Additional Rights Request</h3>
                <div class="col-sm-12 overflowbox table_formate_stayle_font">
                    <table id="zero_config" class="table table-striped text-nowrap dataTable no-footer"
                    role="grid" aria-describedby="zero_config_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                colspan="1" aria-sort="ascending" aria-label="SN: activate to sort column descending"
                                style="width: 0px;">SN
                            </th>
                            <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config"
                                rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">User Name
                            </th>
    
                            <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config"
                                rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Reason</th>
    
                            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4)
                                <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config"
                                    rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php $sn = 1; @endphp
                        @foreach($right_requests as $right_req)
                            <tr>
                                <td>{{$sn++}}</td>
                                <td>{{$right_req->getRaisedBy?->name}}</td>
                                <td>{{$right_req->reason ?? ''}}</td>
                               
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4)
                                    <td>
                                        <div class="delete_icon">
                                            <div class="d-flex gap-3" style="max-width: 100px;">
                                                <span><a
                                                        href="{{route('backend.additional_rights_request.view', Crypt::encrypt($right_req->id))}}"><i
                                                            class="ri-eye-line"></i></a></span>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
            </table> 
            </div>
        </div> 
    </div> 
    @endif



    @endif

      </div>

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
  @endif
@endsection

@endsection