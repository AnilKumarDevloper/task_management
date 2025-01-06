@extends('layouts/backend/main'); 
@section('main_section')
<div class="container-fluid">
    <div class="row">
    <h1>Admin</h1>

        <div class="col-lg-12">
            <div class="card-group">
                <div class="card">
                    <div class="card-body">
                        <span class="
                         btn btn-xl btn-light-info
                         text-info
                         btn-circle
                         d-flex
                         align-items-center
                         justify-content-center
                                                          ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </span>
                        <h3 class="mt-3 pt-1 mb-0">
                            39

                        </h3>
                        <h6 class="text-muted mb-0 fw-normal">New Task</h6>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <span class="
                                                            btn btn-xl btn-light-warning
                                                            text-warning
                                                            btn-circle
                                                            d-flex
                                                            align-items-center
                                                            justify-content-center
                                                          ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-package">
                                <path
                                    d="M12.89 1.45l8 4A2 2 0 0 1 22 7.24v9.53a2 2 0 0 1-1.11 1.79l-8 4a2 2 0 0 1-1.79 0l-8-4a2 2 0 0 1-1.1-1.8V7.24a2 2 0 0 1 1.11-1.79l8-4a2 2 0 0 1 1.78 0z">
                                </path>
                                <polyline points="2.32 6.16 12 11 21.68 6.16"></polyline>
                                <line x1="12" y1="22.76" x2="12" y2="11"></line>
                                <line x1="7" y1="3.5" x2="17" y2="8.5"></line>
                            </svg>
                        </span>
                        <h3 class="mt-3 pt-1 mb-0">
                            43

                        </h3>
                        <h6 class="text-muted mb-0 fw-normal">In Process</h6>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <span class="
                                                            btn btn-xl btn-light-danger
                                                            text-danger
                                                            btn-circle
                                                            d-flex
                                                            align-items-center
                                                            justify-content-center
                                                          ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-bar-chart">
                                <line x1="12" y1="20" x2="12" y2="10"></line>
                                <line x1="18" y1="20" x2="18" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="16"></line>
                            </svg>
                        </span>
                        <h3 class="mt-3 pt-1 mb-0 d-flex align-items-center">
                            423

                        </h3>
                        <h6 class="text-muted mb-0 fw-normal">Completed</h6>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <span class="
                                                            btn btn-xl btn-light-success
                                                            text-success
                                                            btn-circle
                                                            d-flex
                                                            align-items-center
                                                            justify-content-center
                                                          ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-refresh-cw">
                                <polyline points="23 4 23 10 17 10"></polyline>
                                <polyline points="1 20 1 14 7 14"></polyline>
                                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                            </svg>
                        </span>
                        <h3 class="mt-3 pt-1 mb-0">
                            83

                        </h3>
                        <h6 class="text-muted mb-0 fw-normal">Total Clients</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---task area end-->

    <div class="card opacityClass" style="border-radius: 10px;  padding: 20px">
            <div class="row">
                <div class="col-sm-12 overflowbox table_formate_stayle_font">
                    <table id="zero_config" class="table table-striped table-bordered text-nowrap dataTable no-footer" role="grid"
                        aria-describedby="zero_config_info">
                        <thead>
                            <tr role="row">
            
                                <th class="sorting text-dark text-dark" tabindex="0" aria-controls="zero_config" rowspan="1" colspan="1"
                                    aria-label="Department Name: activate to sort column ascending" style="width: 0px;">FY</th>
            
                                <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                    colspan="1" aria-label="Action: activate to sort column ascending">
                                    Month</th>
            
                                <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                    colspan="1" aria-label="Action: activate to sort column ascending">
                                    Compliance</th>
            
                                <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                    colspan="1" aria-label="Action: activate to sort column ascending">
                                    Due Date</th>
            
                                <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                    colspan="1" aria-label="Action: activate to sort column ascending">
                                    Completed date</th>
            
                                <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                    colspan="1" aria-label="Action: activate to sort column ascending">
                                    Document Link</th>
                                <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                    colspan="1" aria-label="Action: activate to sort column ascending">
                                    Responsibly name
                                </th>
            
                                <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                    colspan="1" aria-label="Action: activate to sort column ascending">
                                    Options</th>
                                <th style="width: 0px;" class="sorting text-dark" tabindex="0" aria-controls="zero_config" rowspan="1"
                                    colspan="1" aria-label="Action: activate to sort column ascending">
                                    Last Edited By & Creator name
                                </th>
            
                            </tr>
                        </thead>
                        <tbody>
            
            
                            <tr role="row" class="odd">
            
                                <td>2023-24</td>
                                <td><a href="#">October</a></td>
                                <td>Task 3</td>
                                <td>05/09/2024</td>
                                <td>20/09/2024</td>
                                <td><a href="#">document_01.doc</a></td>
                                <td>Abhishek kumar</td>
            
                                <td>
                                    <div class="delete_icon">
            
                                        <div class="d-flex gap-3" style="max-width: 100px;">
                                            <span>
                                                <a href="#" class="editcolor"><i class="ri-pencil-line"></i></a>
                                            </span>
                                            <span>
                                                <i class="ri-delete-bin-5-line"></i>
                                            </span>
                                            <span>
                                                <i class="ri-eye-line"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="dv">
                                        <span>
                                            <div><span><b>Creator Name : </b>Sandeep</span></div>
                                            <div><span><b>Last Edited By : </b>Abhishek kumar</span></div>
                                        </span>
                                    </div>
                                </td>
            
            
                            </tr>
            
                        </tbody>
                    </table>
                </div>
            </div>
    </div> 
</div>

</div>

</div>

@endsection