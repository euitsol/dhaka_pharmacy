<div class="row px-4">
    <div class="col-4 mx-auto">
        <form action="{{ route('lam.earning.report') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>{{ __('Please choose the date range to receive a report on your email activity.') }}</label>
                <input type="text" id="reportDateRange" class="form-control" />
                <input type="hidden" name="from_date" id="fromDate">
                <input type="hidden" name="to_date" id="toDate">
                <input type="submit" class="btn btn-primary float-end" value="Submit" />
            </div>
        </form>
    </div>
</div>
@if ($errors->any())
    @push('js')
        <script>
            toastr.error(`{{ $errors->all()[0] }}`);
        </script>
    @endpush
@endif
