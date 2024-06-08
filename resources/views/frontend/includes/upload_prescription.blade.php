{{-- Prescription Upload Modal  --}}
<div class="modal up_modal fade" style="z-index: 99999999999999;" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Order By Prescription') }}</h5>
                <button type="button" class="close  px-2 border-1 border-danger rounded-1 text-danger"
                    data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('u.obp.up') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="prescription">{{ __('Prescription Image') }}</label>
                        <input type="file" name="uploadfile" data-actualName="image" class="form-control"
                            id="prescription" accept="image/*">
                    </div>
                    <div class="form-group text-end mt-3">
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('filepond.fileupload')
@push('js')
    <script src="{{ asset('user/asset/js/up.js') }}"></script>
    <script>
        file_upload(["#prescription"], "uploadfile");
        const auth = "{{ Auth::guard('web')->check() }}";
        const login_route = "{{ route('login') }}";
    </script>
@endpush
