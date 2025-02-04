@extends('layouts/backend/main')
@section('main_section')
<div class="page-titles">
    <div class="row">
        <div class="col-lg-8 col-md-6 col-12 align-self-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li>
                  <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0)" class="link">Financial Year List</a></li>
                 </ol>
            </nav>
            <h1 class="mb-0 fw-bold">Financial Year List</h1>
        </div>
        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
        <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
            <a href="{{route('backend.fy_year.create')}}"
                class="btn d-flex align-items-center justify-content-center d-block w-100 btn-info waves-effect waves-light">
                <i class="ri-add-line fs-6 me-2"></i> Add Year
            </a>
        </div>
        @endif 
    </div>
</div>
<div class="container-fluid">
    <div class="card opacityClass" style="border-radius: 10px;  padding: 20px">
            <!---search box --->
            <!-- <div class="col-md-7 col-lg-4 mb-3">
                <div class="form-group d-flex gap-1">
                    <input type="text" class="form-control" placeholder="Search Title..." style="border: 1px solid #54667a;"
                        id="SearchTitle">
                    <button class="btn btn-info">Search</button>
                </div>
            </div> -->
            <!---search box  end--->
            <div class="row">
                <div class="col-sm-12 table_formate_stayle_font overflowbox">
                    @php $sn = 1;
                    @endphp
                    <table id="fy_list_table" class="table table-striped table-bordered text-nowrap dataTable no-footer" role="grid"
                        aria-describedby="zero_config_info">
                        <thead>
                            <tr role="row" class="subHeaderTable">
                                <th class="sorting_asc text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="SN: activate to sort column descending" style="width: 0px;">SN
                                </th>
                                <th class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1"
                                    aria-label="Department Name: activate to sort column ascending" style="width: 0px;">Name
                                </th>
                                <th class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1"
                                    aria-label="Department Name: activate to sort column ascending" style="width: 0px;">Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
            
                            @foreach($years as $year)
                                <tr role="row" class="odd">
                                    <td class="sorting_1">{{$sn++}}.</td>
                                    <td>{{$year->name}}</td>
                                    <td>
                                        <div class="delete_icon">
                                            <div class="d-flex gap-3" style="max-width: 100px;">
                                                <span title="Edit"><a
                                                        href="{{route('backend.fy_year.edit', [Crypt::encrypt($year->id)])}}"><i
                                                            class="ri-pencil-line"></i></a></span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$years->links('pagination::bootstrap-5')}}
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
          $(document).ready(function() {
            $('#fy_list_table').DataTable();
        });
 </script>
  
@endsection 
@endsection