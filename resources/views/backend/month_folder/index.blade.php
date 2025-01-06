@extends('layouts/backend/main')
@section('main_section') 
<div class="page-titles">
          <div class="row">
            <div class="col-lg-8 col-md-6 col-12 align-self-center"> 
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                    <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li> 
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.main_folder.index')}}" class="link">Client Folders</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.year_folder.index', [Crypt::encrypt($main_f->id)])}}" class="link">{{$main_f->label}}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="" class="link">{{$year_f->label}}</a></li>
                </ol>
            </nav>
              <h3 class="mb-0 fw-bold">Client Folders > {{$main_f->label}} > {{$year_f->label}}</h3>
            </div>
             
          </div>
        </div>
        <div class="container-fluid">
          <div class="row" id="addFolderHere"> 
            @if(count($month_folder_list) > 0)
            @foreach($month_folder_list as $m_folder) 
            <div class="col-lg-2">
              <div class="folder_page">
                <div class="folder_icon">
                  <a href="{{route('backend.document.index', [Crypt::encrypt($m_folder->main_folder_id), Crypt::encrypt($m_folder->year_folder_id), Crypt::encrypt($m_folder ->id)])}}"><i class="fas fa-folder"></i></a>
                  <h5>{{$m_folder->label ?? ''}}</h5>
                </div>
                <div class="three_dot" id="edit_file">
                  <div class="dropdown">
                    <button class="btn btn-link" type="button" id="threeDotsMenu" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="threeDotsMenu" style="">
                      <li><a class="dropdown-item" href="">Permissions</a></li>
                      <li><a class="dropdown-item" href="Add_document.html">Upload File</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div> 
            @endforeach
            @else
            <h1>No Folder Available</h1>
            @endif 
          </div> 
        </div> 

@section('javascript_section') 
@endsection 
@endsection