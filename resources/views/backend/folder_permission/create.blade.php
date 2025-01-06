@extends('layouts/backend/main')
@section('main_section')
<div class="page-titles">
    <div class="row">
        <div class="col-lg-8 col-md-6 col-12 align-self-center"> 
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li> 
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.employee.index')}}" class="link">Employee Management</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="" class="link">Folder Permission</a></li>
                </ol>
            </nav> 
            <h3 class="mb-0 fw-bold">Folder Permission</h3>
        </div> 
    </div>
</div>
 
<div class="container-fluid">
    <form action="" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="">
        <input type="hidden" name="user_email" value="">
        <div class="form-group row">
            <div class="col-md-4">
                <div class="form-group row">    
                    <div class="col-sm-4">
                        <label for="name" class="form-label">Name :</label>
                    </div>
                    <div class="col-sm-9">
                        <p>ghfdhfd</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="email" class="form-label">Email :</label>
                    </div>
                    <div class="col-sm-9">
                        <p>dgdfg</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="phone" class="form-label">Phone :</label>
                    </div>
                    <div class="col-sm-9">
                        <p>sdfsdf</p>
                    </div>
                </div>
            </div>
        </div> 
        <div class="card mt-3">
            <div class="card-header header-btn d-flex justify-content-end">
                <button type="button" class="btn btn-dark m-1" id="checkAll">CHECK ALL</button>
                <button type="button" class="btn btn-dark m-1" id="checkNone">CHECK NONE</button>
            </div>
            <div class="card-body">  
                <div class="form-group row config-system">
                    <div class="col-md-2">
                        <input type="checkbox" class="main_folder_checkbox" name="main_folder_permission_ids[]"  value="fdgdfg">
                        <label for="main_folder_permission_ids" class="form-label">Company Name</label>
                    </div>
 

                    <div class="col-md-8"> 
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="checkbox" class="year_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                <label for="view_checkbox" class="form-label">2023</label>
                                <div class="row">
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">January</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">February</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">March</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">April</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">May</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">June</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">July</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">August</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">September</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">October</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">November</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">December</label>
                                    </div>
                                </div>
                            </div>   
                            <div class="col-sm-4">
                                <input type="checkbox" class="year_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                <label for="view_checkbox" class="form-label">2024</label>
                                <div class="row">
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">January</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">February</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">March</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">April</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">May</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">June</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">July</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">August</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">September</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">October</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">November</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">December</label>
                                    </div>
                                </div>
                            </div>   
                            <div class="col-sm-4">
                                <input type="checkbox" class="year_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                <label for="view_checkbox" class="form-label">2025</label>
                                <div class="row">
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">January</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">February</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">March</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">April</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">May</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">June</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">July</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">August</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">September</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">October</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">November</label>
                                    </div>
                                    <div class="col-md-12">
                                    <input type="checkbox" class="month_folder_checkbox" name="sub_permission_ids[]"  value="DSFGDSFG">
                                    <label for="view_checkbox" class="form-label">December</label>
                                    </div>
                                </div>
                            </div> 
                        </div> 
                    </div>    
 
                    <div class="col-md-2 btn-col">
                        <div class="row">
                            <div class="col-sm-2 check-btn d-flex">
                                <button type="button" class="btn btn-primary check-all-btn m-1">all</button>
                                <button type="button" class="btn btn-primary check-none-btn m-1">none</button>
                            </div>
                        </div>
                    </div> 
                </div>  
                <input type="submit" class="btn btn btn-success" value="Submit"> 
            </div>
        </div>
    </form>
</div>




@section('javascript_section') 
<script>   
    $('.main_folder_checkbox').on('change', function() {
        let mainCheckbox = $(this); 
        var container = mainCheckbox.closest('.config-system');
        var month_folder_checkbox = container.find('.month_folder_checkbox');
        var year_folder_checkbox = container.find('.year_folder_checkbox');
        if(mainCheckbox.is(':checked')){
            month_folder_checkbox.prop('checked', true);
            year_folder_checkbox.prop('checked', true);
        }else{
            month_folder_checkbox.prop('checked', false);
            year_folder_checkbox.prop('checked', false);
        }
    }); 

    $('.year_folder_checkbox').on('change', function() {
        var container = $(this).closest('.config-system');
        var mainCheckbox = container.find('.main_folder_checkbox');
        var subCheckboxes = container.find('.year_folder_checkbox');
        if(subCheckboxes.filter(':checked').length > 0){ 
            mainCheckbox.prop('checked', true);
        }else{
            mainCheckbox.prop('checked', false);
        }
    });
 
    function checkAll(name) {
        const checkboxes = document.querySelectorAll(`input[name=${name}]`);
        checkboxes.forEach(checkbox => checkbox.checked = true);
    }

    function checkNone(name) {
        const checkboxes = document.querySelectorAll(`input[name=${name}]`);
        checkboxes.forEach(checkbox => checkbox.checked = false);
    }

    document.getElementById('checkAll').addEventListener('click', () => {
        const checkboxes = document.querySelectorAll('input[type=checkbox]');
        checkboxes.forEach(checkbox => checkbox.checked = true);
    });

    document.getElementById('checkNone').addEventListener('click', () => {
        const checkboxes = document.querySelectorAll('input[type=checkbox]');
        checkboxes.forEach(checkbox => checkbox.checked = false);
    });

    $(document).ready(function(){
            $('#checkAll').click(function() {
                $('input[type="checkbox"]').prop('checked', true);
            });
            $('#checkNone').click(function() {
                $('input[type="checkbox"]').prop('checked', false);
            });
            
            $('.check-all-btn').click(function() {
                $(this).closest('.form-group').find('input[type="checkbox"]').prop('checked', true);
            });
            $('.check-none-btn').click(function() {
                $(this).closest('.form-group').find('input[type="checkbox"]').prop('checked', false);
            });
    });

</script>
@endsection
 
@endsection