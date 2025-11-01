<script src="{{ asset('assets/plugins/jquery@3.7.1/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap@5.2.3/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-select@1.14.0/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweet-alert2@11.10.6/sweet-alert.min.js') }}"></script>
<script src="{{ asset('assets/plugins/OwlCarousel2-2.3.4/dist/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jalalidate/jalalidate.min.js') }}"></script>
<script src="{{ asset('assets/plugins/cute-alert-master/cute-alert.js') }}"></script>
<script src="{{ asset('assets/js/panel.js') }}"></script>
@if (session('success'))
    <script>
        $(document).ready(function() {
            cuteToast({
                type: "success",
                title: "انجام شد",
                message: "{{ session('success') }}",
                timer: 5000
            })
        });
    </script>
@endif
@if (session('error'))
    <script>
        $(document).ready(function() {
            cuteToast({
                type: "error",
                title: "خطا",
                message: "{{ session('error') }}",
                timer: 5000
            })
        });
    </script>
@endif
@if (session('warning'))
    <script>
        $(document).ready(function() {
            cuteToast({
                type: "warning",
                title: "هشدار",
                message: "{{ session('warning') }}",
                timer: 5000
            })
        });
    </script>
@endif
@if (session('info'))
    <script>
        $(document).ready(function() {
            cuteToast({
                type: "info",
                title: "پیغام",
                message: "{{ session('info') }}",
                timer: 5000
            })
        });
    </script>
@endif
@if ($errors->any())
    @foreach ($errors->getMessages() as $key => $error)
        <script>
            $('[name={{ $key }}]').addClass('border border-danger');
        </script>
    @endforeach
@endif
