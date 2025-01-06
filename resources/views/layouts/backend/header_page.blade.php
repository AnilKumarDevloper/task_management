<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    <meta name="robots" content="noindex,nofollow" />
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Task Management</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png" /> 

     <link href="{{url('assets/backend/dist/css/style.min.css')}}" rel="stylesheet" /> 
     <!-- <link rel="stylesheet" href="{{url('assets/backend/select/css/select2.css')}}"> -->
     <!-- <link rel="stylesheet" href="{{url('assets/backend/select/css/select2.min.css')}}"> -->
     <link rel="stylesheet" href="{{url('assets/backend/libs/prism/prism.css')}}">
     <link rel="stylesheet" href="{{url('assets/backend/css/styles.css')}}">
     <link rel="stylesheet" href="{{url('assets/backend/dist/css/custom.css')}}">
    
</head> 
@php
$layout_setting = \App\Models\Backend\LayoutSetting::where('id', 1)->first();
@endphp
<style>
    .select2-container--classic .select2-selection--multiple .select2-selection__choice,
    .select2-container--default .select2-selection--multiple .select2-selection__choice,
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        background-color: #0bb2fb !important;
        color: #fff;
    }

    .profilepageelementPage {
        position: absolute;
        right: 0;
    }

    /* #navbarSupportedContent{
        background: {{$layout_setting->navbar_color}};
    } */
</style>
<body> 
    <div id="main-wrapper" class="">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                     <a class="nav-toggler waves-effect waves-light d-block d-md-none" id="menubar_open" href="javascript:void(0)"><i
                            class="ri-close-line ri-menu-2-line fs-6 close_icon"></i></a> 
                    <a class="navbar-brand" href="#"> 
                        <b class="logo-icon">
                            <!-- <span><i class="ri-stack-line"></i></span> -->
                             <span>
                                <img src="{{url($layout_setting->logo_image_path . '/' . $layout_setting->logo_image)}}"  style="width: 40px;" >
                             </span>
                                    <!-- <img src="{{url($layout_setting->logo_image_path . '/' . $layout_setting->logo_image)}}" alt="homepage" class="light-logo" style="width: 40px;" /> -->
                        </b>
                        <span class="logo-text"> 
                            <span class="d-flex121">
                                <spam class="logo_text_color" style="color:{{$layout_setting->logo_text_color}}"> {{$layout_setting->logo_text ?? 'NDM Advisors LLP'}}</spam>
                                <span class="sub_logo_text pt-1" style="font-size:12px; color:{{$layout_setting->logo_sub_heading_color}}">
                                       {{substr($layout_setting->logo_sub_heading_text, 0, 23)}}
                                       <br>
                                        {{substr($layout_setting->logo_sub_heading_text, 23, 100)}}
                                </span> 
                            </span>
                            <!-- <img src="{{url('assets/backend/images/logo-light-text.png')}}" class="light-logo" alt="homepage" /> -->
                        </span>
                    </a>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ri-more-line fs-6"></i></a>
                </div> 
                <div class="navbar-collapse collapse header_background" id="navbarSupportedContent" style="background:{{$layout_setting->navbar_color}};" >
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link sidebartoggler d-none d-md-block" href="javascript:void(0)"><i data-feather="menu"></i></a>
                        </li>
                        <!-- <li class="nav-item search-box">
                            <a class="nav-link" href="javascript:void(0)">
                                <i data-feather="search"></i>
                            </a>
                            <form class="app-search position-absolute">
                                <input type="text" class="form-control border-0" placeholder="Search &amp; enter" />
                                <a class="srh-btn"><i data-feather="x-circle" class="feather-sm text-muted"></i></a>
                            </form>
                        </li>  -->
                    </ul>  
                    @if(Auth::user()->role_id == 4)
                    @php
    if (Auth::user()->role_id == 4) {
        $company = App\Models\Backend\CompanyDetail::where('user_id', Auth::user()->id)->first();
    } 
                    @endphp
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item d-flex gap-3 align-items-center">
                            @if($company->logo != null) 
                          
                            <img src="{{url($company->logo_url . '/' . $company->logo)}}" alt="" style="width: 90px;" >
                            @endif
                          <h5 class="mb-0 pb-0">{{$company->name ?? ''}}</h5> 
                        </li>
                    </ul>
                    @endif 
                    <ul class="navbar-nav"> 
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center clicknottification" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-bell">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                </svg>
                                @php
$notifications = \App\Models\Backend\Notification::where('for', Auth::user()->id)->orderBy('id', 'desc')->get();

$unread_notifications = \App\Models\Backend\Notification::where('status', 1)->where('for', Auth::user()->id)->count();
                                @endphp
                                
                                    <div class="notify" style="left:-5px; top:-15px">
                                        <!-- <span class="point bg-primary"></span> -->
                                         <div class="border-radius text-white d-flex align-items-center justify-content-center " style="width:20px; height:20px; border-radius:50%;font-size:12px; background:red;" >
                                            <span>{{$unread_notifications}}</span>
                                         </div>
                                    </div>  
                               
                            </a>
                            <div class="dropdown-menu dropdown-menu-end mailbox dropdown-menu-animate-up profilepageelementPage notificationPageelement">
                               
                            <ul class="list-style-none">
                                    <li>
                                        <div class="rounded-top p-30 pb-2 d-flex align-items-center">
                                            <h3 class="card-title mb-0">Notifications</h3>
                                            <span class="badge bg-warning ms-3">{{$unread_notifications}} new</span>
                                        </div>
                                    </li>
                                    <li class="p-30 pt-0">
                                        <div class="message-center message-body position-relative ps-container ps-theme-default"
                                            data-ps-id="b545ff8f-2973-75cb-99ff-d0087a11509d"> 
                                            @if(count($notifications) > 0)
                                                @foreach($notifications as $notification)
                                                    <a href="{{route('backend.notification.view', [$notification->id])}}" class="message-item px-2 d-flex align-items-center border-bottom py-3 mb-2  {{$notification->status == 1 ? 'unreaded_notifications' : ""}}"  >
                                                        <span class="btn btn-light-info text-info btn-circle">
                                                              {!! $notification->icon !!}
                                                        </span>
                                                        <div class="w-75 d-inline-block v-middle ps-3 ms-1">
                                                            <h5 class="message-title mb-0 mt-1 fs-4 font-weight-medium">{{$notification->text}}</h5>
                                                            <span class="fs-3 text-nowrap d-block time text-truncate fw-normal mt-1 text-muted">{{ $notification->created_at->diffForHumans() }}</span>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            @endif   
                                            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                                                <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                            </div>
                                            <div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;">
                                                <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                            </div>
                                        </div>
                                        <!-- <div class="mt-4">
                                            <a class="btn btn-info text-white" href="javascript:void(0);">
                                                See all notifications
                                            </a>
                                        </div> -->
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown profile-dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center clickprofile" href="#" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                @if(Auth::user()->profile != '')
                                <img src="{{url(Auth::user()->profile)}}" alt="user" class="profile-pic rounded-circle" id="output"  style="width:30px; height:30px; border-radius:50%;"/>
                                @else
                                    <img src="{{url('assets/backend/images/users/user.png')}}" alt="user" class="profile-pic rounded-circle" id="output" style="width:30px; height:30px; border-radius:50%;"/>
                                   @endif
                               
                                <div class="d-none d-md-flex align-items-center ">
                                    <span class="ms-2">Hi,
                                        <span class="text-dark fw-bold">{{Auth::user()->name}}</span></span>
                                    <span><i data-feather="chevron-down" class="feather-sm"></i></span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end mailbox dropdown-menu-animate-up profilepageelement profilepageelementPage">
                                <ul class="list-style-none">
                                    <li class="p-30 pb-2">
                                        <div class="rounded-top d-flex align-items-center">
                                            <h3 class="card-title mb-0">User Profile</h3>
                                            <div class="ms-auto">
                                                <a href="" class="link py-0">
                                                    <i data-feather="x-circle"></i>
                                                </a>
                                            </div>
                                        </div>
        
                                        <div class="d-flex align-items-center mt-4 pt-3 pb-4 border-bottom">
                                            <div class="profile-pic">
                                                <label class="-label" for="file">
                                                    <span><i class="ri-camera-line"></i></span>
                                                    <!-- <span><b>Change Image</b></span> -->
                                                </label>
                                                 @if(Auth::user()->profile != '')
                                                 <img src="{{url(Auth::user()->profile)}}"
                                                 id="output" width="200"/>
                                                 @else
                                                <img src="{{url('assets/backend/images/users/user.png')}}"
                                                    id="output" width="200"/>
                                                @endif
                                            </div>
        
                                            <div class="ms-4">
                                                <h4 class="mb-0">{{Auth::user()->name}}</h4>
                                                <span class="text-muted">
                                                    @if(Auth::user()->role_id == 1)
                                                    Super Admin 
                                                    @elseif(Auth::user()->role_id == 2)
                                                    Admin
                                                    @elseif(Auth::user()->role_id == 3)
                                                    Employee
                                                    @elseif(Auth::user()->role_id == 4)
                                                    Client
                                                    @endif
                                                </span>
                                                <p class="text-muted mb-0 mt-1">
                                                    <i data-feather="mail" class="feather-sm me-1"></i>
                                                    {{Auth::user()->email}}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
        
                                    <li class="p-30 pt-0">
                                        <div class="message-center message-body position-relative" style="height: 140px">
                                            <a href="{{route('backend.profile.index')}}" class="message-item px-2 d-flex align-items-center border-bottom py-3">
                                                <span class="btn btn-light-info btn-rounded-lg text-info">
                                                    <i class="ri-profile-line"></i>
                                                </span>
                                                <div class="w-75 d-inline-block v-middle ps-3 ms-1">
                                                    <h5 class="message-title mb-0 mt-1 fs-4 font-weight-medium">
                                                        My Profile
                                                    </h5>
                                                    <span class="fs-3 text-nowrap d-block time text-truncate fw-normal mt-1 text-muted">Account Settings</span>
                                                </div>
                                            </a>  
                                        </div>
                                        <div class="mt-4">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a class="btn btn-info text-white" href="#" onclick="event.preventDefault(); this.closest('form').submit();"> {{ __('Log Out') }}</a> 
                                         </form> 
                                        </div>
                                    </li>
                                </ul>
                            </div> 
                        </li>
                    </ul>
                    

                </div>

            </nav>
        </header>
        
        <aside class="left-sidebar sidbar_background_color" style="background-color:{{$layout_setting->sidebar_color}}"> 
            <div class="scroll-sidebar" style="height: 100%;"> 
                <nav class="sidebar-nav" style="height: 100%;" >
                    <ul id="sidebarnav" class="sidbar_background_color" style="background-color:{{$layout_setting->sidebar_color}}; height:100%"> 
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('backend.dashboard.view')}}" aria-expanded="false">
                                <i class="ri-dashboard-line"></i> <span class="hide-menu">Dashboard</span></a>
                        </li>
                       @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('backend.employee.index')}}" aria-expanded="false">
                                <i class="ri-group-line"></i><span class="hide-menu">Employee Managemen</span>
                            </a>
                        </li> 
                        @endif

                        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('backend.client.index')}}" aria-expanded="false">
                                <i data-feather="message-circle"></i><span class="hide-menu">Client Managment</span>
                            </a>
                        </li> 
                        @endif
                      
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('backend.task.index')}}" aria-expanded="false">
                                <i class="ri-task-line"></i> <span class="hide-menu">Task Managment</span>
                            </a>
                        </li> 

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('backend.ticket.index')}}" aria-expanded="false">
                            <i class="ri-ticket-2-line"></i> <span class="hide-menu">Ticket Portal                               </span>
                            </a>
                        </li> 
                        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4)
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('backend.authority_matrix.index')}}" aria-expanded="false">
                                    <i class="ri-safe-2-line"></i> <span class="hide-menu">Authority Matrix
                                </a>
                            </li> 
                            @endif

                            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('backend.additional_rights_request.index')}}" aria-expanded="false">
                                    <i class="ri-task-line"></i> <span class="hide-menu">Add. Rights Req.</a>
                            </li> 
                            @endif

                        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                            <i class="ri-settings-3-line fs-7"></i><span class="hide-menu">Setting </span></a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{route('backend.fy_year.index')}}" class="sidebar-link"><i class="ri-ticket-line"></i><span class="hide-menu"> FY List</span></a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{route('backend.setting.layout_color')}}" class="sidebar-link"><i class="ri-ticket-line"></i><span class="hide-menu">Layout Setting</span></a>
                                </li> 
                            </ul>
                        </li>
                        @endif

                    </ul>
                </nav> 
            </div> 
        </aside>
      
        <div class="page-wrapper"
         style="background-image: url({{url($layout_setting->bg_image_path . '/' . $layout_setting->bg_image)}});
                background-size: cover; 
                background-repeat: no-repeat; background-attachment: fixed;
                background-position: center;
                min-height:100vh
                ">
    
 