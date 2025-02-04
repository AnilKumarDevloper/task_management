@extends('layouts/backend/main')
@section('main_section')  
    <div class="page-titles pb-0">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 d-flex align-items-center">
                                <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li>
                                 <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);" class="link">Layout Color</a></li>
                            </ol>
                        </nav>
                        <h3 class="mb-0 fw-bold">Layout Setting</h3>
                    </div>
                    <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
                    </div>
                </div>
            </div> 
            <div class="container-fluid">
            <div class="card opacityClass" style="border-radius: 10px;  padding: 20px">
            <div class="row">
        <div class="col-lg-12"> 
               
                <div class="tab-content" id="pills-tabContent" style="border: 1px solid #d3d3d3;">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="pills-timeline-tab" data-bs-toggle="pill" href="" role="tab" aria-controls="pills-timeline" aria-selected="true">Layout Setting</a></li>
                </ul>

                    <div class="card-body" >
                        <form class="form-material" action="{{route('backend.setting.update_layout_color')}}" enctype="multipart/form-data" method="POST">
                        @csrf 
                       <div class="row">
                            <div class="col-md-6">
                                <label class="col-md-12"><b class="boldname">Background Image</b></label>
                                <!-- <input type="file" name="bg_image" class="" style="max-width:250px;"> -->
                             
                                <!-- <input class="form-control form-white input_border"  name="bg_image"  type="file"
                                   style="max-width:250px;"> -->
                                <input class="form-control form-white input_border" name="bg_image" type="file" 
                                    style="max-width: 500px; padding-top: 5px; padding-left: 10px; background-color:#ecf0f2">
                                <br>
                                <br>
                                <img src="{{url($layout_setting->bg_image_path . '/' . $layout_setting->bg_image)}}" width="50%">    
                            </div> 
                            <div class="col-md-6">
                                <label class="col-md-12"><b class="boldname" >Site Logo</b></label>                               
                                <!-- <input type="file" name="site_logo" class="" style="max-width:250px;" id="site_logo"> -->
                                <input class="form-control form-white input_border" id="site_logo" name="site_logo" type="file"
                                    style="max-width: 500px; padding-top: 5px; padding-left: 10px; background-color:#ecf0f2">
                             
                                <br>
                                <br>
                                <img src="{{url($layout_setting->logo_image_path . '/' . $layout_setting->logo_image)}}" width="30%">    

                            </div>

                       </div>
                         
                        <hr>
                        <hr>
                        <div class="row mb-4 mt-4 ">
                            
                            <div class="mb-3 col-md-2 col-6">
                                <label for="example-email" class="textcenterElement"><b class="boldname">Navbar Background</b></label>
                                <div class="colmd12 d-flex justify-content-center">
                                    <input type="color" name="navbar_color" class="form-control form-control-line color_picker" id="navbar_color" value="{{$layout_setting->navbar_color}}">
                                </div>
                            </div>
                            <div class="mb-3 col-md-2 col-6">
                                <label for="example-email" class="textcenterElement"><b class="boldname"> Sidbar Background </b></label>
                                <div class="colmd12 d-flex justify-content-center">
                                    <input type="color" name="sidebar_background" class="form-control form-control-line color_picker" value="{{$layout_setting->sidebar_color}}" id="sidebar_background">
                                </div>
                            </div>
                            <div class="mb-3 col-md-2 col-6">
                                <label for="example-email" class="textcenterElement"><b class="boldname">Logo Heading Color</b></label>
                                <div class="colmd12 d-flex justify-content-center">
                                    <input type="color" name="logo_text_color" class="form-control form-control-line color_picker" value="{{$layout_setting->logo_text_color}}" id="logo_text_color">
                                </div>
                            </div>

                            <div class="mb-3 col-md-3 col-6">
                                <label for="example-email" class="textcenterElement"><b class="boldname">Logo Sub Heading Color</b></label>
                                <div class="colmd12 d-flex justify-content-center">
                                    <input type="color" name="sub_logo_text_color" class="form-control form-control-line color_picker"
                                        value="{{$layout_setting->logo_sub_heading_color}}" id="sub_logo_text_color">
                                </div>
                            </div>

                            <div class="mb-3 col-md-3 col-6">
                                <label for="example-email" class="textcenterElement"><b class="boldname">Copyright Text Color</b></label>
                                <div class="colmd12 d-flex justify-content-center">
                                    <input type="color" name="footer_text_color" class="form-control form-control-line color_picker" value="{{$layout_setting->footer_text_color}}" id="footer_text_color">
                                </div>
                            </div>
                            <hr>
                            <hr>
                            
                            

                            <div class="mb-3 col-md-2 col-6">
                                <label for="example-email" class="textcenterElement"><b class="boldname">Menu Text Color</b></label>
                                <div class="colmd12 d-flex justify-content-center">
                                    <input type="color" name="menu_text_color" class="form-control form-control-line color_picker" value="{{$layout_setting->menu_text_color}}" id="menu_text_color" >
                                </div>
                            </div> 
                            <div class="mb-3 col-md-3 col-6">
                                <label for="example-email" class="textcenterElement"><b class="boldname">User Name Text Color</b></label>
                                <div class="colmd12 d-flex justify-content-center">
                                    <input type="color" name="user_name_text_color" class="form-control form-control-line color_picker" value="{{$layout_setting->user_name_text_color}}" id="user_name_text_color" >
                                </div>
                            </div> 
                            <div class="mb-3 col-md-3 col-6">
                                <label for="example-email" class="textcenterElement"><b class="boldname">Notification Icon Color</b></label>
                                <div class="colmd12 d-flex justify-content-center">
                                    <input type="color" name="notification_icon_color" class="form-control form-control-line color_picker" value="{{$layout_setting->notification_icon_color}}" id="notification_icon_color" >
                                </div>
                            </div> 
                          
                         
                         
                            <hr>
                            <hr>    
                          
                            
                        <div class="row">
                                <div class="col-md-5 col-12 mb-3">
                                        <div class="inputChangeElement">
                                            <lable>Logo Heading Text</lable>
                                            <input class="change_textHeding" type="text" id="change_logo_heading_name" name="change_logo_heading_name"  value="{{$layout_setting->logo_text ?? ''}}" >
                                        </div>      
                                </div>

                                <div class="col-md-5 col-12 mb-3">
                                     <div class="inputChangeElement">
                                        <lable>Logo Sub Heading Text</lable>
                                        <input class="change_textHeding" type="text"
                                            id="change_sub_logo_heading_name" name="change_sub_logo_heading_name" value="{{$layout_setting->logo_sub_heading_text ?? ''}}" >
                                    </div>
                                </div>

                                <div class="col-md-5 col-12 mb-3">
                                    <div class="inputChangeElement">
                                        <lable>Copyright Text</lable>
                                        <input class="change_textHeding" type="text"
                                            id="copy_right_text" name="copy_right_text" value="{{$layout_setting->footer_text ?? ''}}">
                                    </div>
                                </div>
                        </div>
                            
                              
                            <div class="mb-3">
                                    <div>
                                        <button type="submit" class="btn btn-success">Update Setting</button>
                                    </div> 
                            </div>
                        </b>
                </form>
                    <div class="d-flex justify-content-end">
                        <form action="{{route('backend.setting.update_default_layout')}}" method="POST" id="default_setting_form">
                            @csrf
                        </form>
                        <button  class="btn btn-primary" id="default_setting_btn">Default Setting</button>
                    </div>
            </div>
          
    
         
         </div>
               
            </div>
            </div>
            </div>



            </div> 



            
@section('javascript_section')
@if(Session::has('new_updated'))
    <script>
    Swal.fire({
        title: "Success",
        text: "{{Session::get('new_updated')}}",
        icon: "success"
    });
    </script>
    @elseif(Session::has('default_updated'))
    <script>
    Swal.fire({
        title: "Success",
        text: "{{Session::get('default_updated')}}",
        icon: "success"
    });
    </script>
@endif

<script>
        $(document).ready(function(){
            $(document).on("click", "#default_setting_btn", function(e){
                event.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Change it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#default_setting_form").submit();
                    }
                });
            })

            $('#navbar_color').on('input', function(){
              let navbar_color = $(this).val();
              $('#navbarSupportedContent').css({
                 'background-color': navbar_color
              });
            });

            $('#sidebar_background').on('input', function (){
                let sidebar_background = $(this).val();
                $('.sidbar_background_color').css({
                    'background-color': sidebar_background,
                });
            });

            $('#logo_text_color').on('input', function (){
                let logo_text_color = $(this).val();
                $('.logo_text_color').css({
                    'color': logo_text_color,
                });
            });

            $('#footer_text_color').on('input', function (){
                let footer_text_color = $(this).val();
                $('.footerCopyRight').css({
                    'color': footer_text_color,
                });
            });

            $('#sub_logo_text_color').on('input', function (){
                let sub_logo_text_color = $(this).val();
                $('.sub_logo_text').css({
                    'color': sub_logo_text_color,
                });
            });
            $('#menu_text_color').on('input', function (){
                let menu_text_color = $(this).val();
                $('.main_menu').css({
                    'color': menu_text_color,
                });
            });
            $('#submenu_text_color').on('input', function (){
                let submenu_text_color = $(this).val();
                $('.sub_menu').css({
                    'color': submenu_text_color,
                });
            });
            $('#user_name_text_color').on('input', function (){
                let user_name_text_color = $(this).val();
                $('.user_name_text_color').css({
                    'color': user_name_text_color,
                });
            });
            $('#notification_icon_color').on('input', function (){
                let notification_icon_color = $(this).val();
                $('.notification_icon_color').css({
                    'color': notification_icon_color,
                });
            });



        })

       
</script>

@endsection
@endsection