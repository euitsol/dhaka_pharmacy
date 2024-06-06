@include('filepond.fileupload')
@push('js')
    <script src="{{ asset('user/asset/js/up.js') }}"></script>
    <script>
        file_upload(["#prescription"], "uploadfile");
        const auth = "{{ Auth::guard('web')->check() }}";
    </script>
@endpush
