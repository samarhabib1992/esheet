<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        // When a collapsible button is clicked
        $('[data-bs-toggle="collapse"]').on('click', function () {
            var target = $(this).attr('data-bs-target');

            // Hide all other collapsible content except the current one
            $('.collapse.show').removeClass('show');

            // Show the current collapsible content
            $(target).addClass('show');
        });
    });
</script>
<script src="{{asset('front/assets/plugins/bootstrap-select.min.js')}}"></script>
<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{asset('front/assets/js/plugins/jquery-3.5.1.min.js')}}"></script>
<script src="{{asset('front/assets/js/plugins/popper.min.js')}}"></script>
<script src="{{asset('front/assets/js/plugins/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('front/assets/js/plugins/bootstrap-select.min.js')}}"></script>

<script src="{{asset('front/assets/js/main.js')}}"></script>
<!-- <script src="{{asset('front/assets/js/demo-1.js')}}"></script> -->

@stack('scripts')
