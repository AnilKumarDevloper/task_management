@extends('layouts/backend/main')
@section('main_section')  
    <div class="page-titles pb-0">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-12 align-self-center"> 
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                        <li class="breadcrumb-item"><a href="{{route('backend.dashboard.view')}}" class="link"><i class="ri-home-3-line fs-5"></i></a></li> 
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('backend.task.index')}}" class="link">Task Management</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0)" class="link">View Document</a></li>
                    </ol>
                </nav>
                <h3 class="mb-0 fw-bold">{{$document->file_original_name}}</h3> 
            </div>
             @php
                $doc_availability = public_path($document->file_path.'/'.$document->file);
            @endphp
            @if(file_exists($doc_availability))
            <div class="col-lg-4 col-md-6 d-none d-md-flex align-items-center justify-content-end">
                <a href="{{route('backend.task.download_task_doc', [Crypt::encrypt($document->id)])}}" class="btn d-flex align-items-center justify-content-center d-block w-100 btn-info waves-effect w-light">
                <i class="ri-download-2-fill fs-6 me-2"></i> Download</a>
            </div>
            @endif
        </div>
    </div> 
    
    <div class="container-fluid">
        <div class="row" id="addFolderHere"> 
         @if(file_exists($doc_availability)) 
            @if($file_type == 'doc' || $file_type == 'docx' || $file_type == 'xls' || $file_type == 'xlsx')
            <div class="col-12" style="position: relative; height: 600px; width: 100%; text-align:center;">  
                <iframe src='https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode(url($document->file_path.'/'.$document->file)) }}' width="100%" height="100% !important"  style="border:1px solid green;"></iframe>
            </div>
            @elseif($file_type == 'pdf')
            <div class="col-12" style="position: relative; width: 100%; text-align:center;">  
            <div id="pdfViewer" style=" text-align:center;"></div> 
            </div>
            @elseif($file_type == 'jpg' || $file_type == 'jpeg' || $file_type == 'png' || $file_type == 'gif' || $file_type == 'webp') 
                    @php
                     $imagePath = public_path($document->file_path.'/'.$document->file);
                        $imageData = file_get_contents($imagePath); 
                        $base64 = base64_encode($imageData);
                        $base64Url = "data:$file_type;base64,$base64"; 
                    @endphp
                    <div class="col-12" style="position: relative; height: 600px; width: 100%; text-align:center;">  
                        <img src="{{$base64Url }}" alt="Image" width="100%">
                    </div>   
                @elseif($file_type == 'txt') 
                        <div class="col-12" style="position: relative; width: 100%; text-align:center;">  
                            <pre style="white-space: pre-wrap; word-wrap: break-word; background:white; height:500%;">{{ file_get_contents(public_path($document->file_path.'/'.$document->file)) }}</pre>
                        </div>  
                @else
                <div class="col-12" style="position: relative; height: 600px; width: 100%; text-align:center;">  
                    <h4 style="color:yellow;">File Format Not Supported</h4>
                </div> 
            @endif  
            
            
            @else
            <div class="col-12" style="position: relative; height: 600px; width: 100%; text-align:center;">  
                        <h4 style="color:yellow;">File Not Found</h4>
                    </div>  
            @endif
             
        </div>
    </div> 
    @section('javascript_section')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script> 
@if($file_type == 'pdf') 
        <script>
            const pdfUrl = "{{ url($document->file_path.'/'.$document->file) }}";
            const pdfViewer = document.getElementById('pdfViewer');
            pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
                const totalPages = pdf.numPages;
                function renderPage(pageNumber) {
                    pdf.getPage(pageNumber).then(function(page) {
                        const scale = 1.5;
                        const viewport = page.getViewport({ scale: scale });
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;
                        pdfViewer.appendChild(canvas);
                        const renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };
                        page.render(renderContext).promise.then(function() {
                            if (pageNumber < totalPages) {
                                renderPage(pageNumber + 1);
                            }
                        });
                    });
                } 
                renderPage(1);
            }).catch(function(error) {
                console.error('Error loading PDF:', error);
            });
        </script> 
@endif
    @endsection  
@endsection 