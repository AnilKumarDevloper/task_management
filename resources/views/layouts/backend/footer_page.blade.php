@php
    $footer_text = \App\Models\Backend\LayoutSetting::where('id', 1)->first();
@endphp

<center>
    <p class="footerCopyRight" style="color:{{$footer_text->footer_text_color}};">&#169;
        {{$footer_text->footer_text ?? 'Copyright 2024. Secretarial Compliance Management (SCM) is a proprietory tool and all Rights reserved with NDM Advisors LLP'}}
    </p>
</center>
<!-- ============================================================= -->

<script src="{{url('assets/backend/libs/jquery/dist/jquery.min.js')}}"> </script>
<script src="{{url('assets/backend/extra-libs/taskboard/js/jquery-ui.min.js')}}"></script>
<!-- Bootstrap tether Core JavaScript -->
<!-- <script src="{{url('assets/backend/libs/popper.js/popper.min.js')}}"></script>
    <script src="{{url('assets/backend/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<!-- apps -->
<!-- <script src="{{url('assets/backend/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script> -->

<script src="{{url('assets/backend/dist/js/app.min.js')}}"></script>
<script src="{{url('assets/backend/dist/js/app.init.js')}}"></script>
<script src="{{url('assets/backend/dist/js/app-style-switcher.js')}}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{url('assets/backend/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{url('assets/backend/extra-libs/sparkline/sparkline.js')}}"></script>
<!--Wave Effects -->
<script src="{{url('assets/backend/dist/js/waves.js')}}"></script>
<!--Menu sidebar -->
<script src="{{url('assets/backend/dist/js/sidebarmenu.js')}}"></script>
<!--Custom JavaScript -->
<script src="{{url('assets/backend/dist/js/feather.min.js')}}"></script>
<script src="{{url('assets/backend/dist/js/custom.min.js')}}"></script>
<script src="{{url('assets/backend/dist/js/custom.js')}}"></script>
<!--This page JavaScript -->
<script src="{{url('assets/backend/assets/libs/moment/min/moment.min.js')}}"></script>
<script src="{{url('assets/backend/assets/libs/fullcalendar/dist/fullcalendar.min.js')}}"></script>
<script src="{{url('assets/backend/dist/js/pages/calendar/cal-init.js')}}"></script>
<script src="{{url('assets/backend/css/myscript.js')}}"></script>

<!---new ad deep -->
<!-- <script src="{{url('assets/backend/select/js/select2.full.js')}}"></script> -->
<script src="{{url('assets/backend/select/js/select2.full.min.js')}}"></script>
<!-- <script src="{{url('assets/backend/select/js/select2.js')}}"></script> -->
<script src="{{url('assets/backend/select/js/select2.min.js')}}"></script>

<script src="{{url('assets/backend/select/js/select2.init.js')}}"></script>

<script src="{{url('assets/backend/libs/prism/prism.js')}}"></script>
<!---new ad deep -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




@yield('javascript_section')
<script>
    $(document).ready(function ()
    {
        $('#menubar_open').on('click', function ()
        {
            if ($('#main-wrapper').hasClass('show-sidebar'))
            {
                $('#main-wrapper').removeClass('show-sidebar');
            } else
            {
                $('#main-wrapper').addClass('show-sidebar');
            }
        });
    });
</script>
</body>

</html>