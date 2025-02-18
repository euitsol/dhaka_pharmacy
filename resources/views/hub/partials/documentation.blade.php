@if ($document)
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <b>{{ $document->title ? ucfirst($document->title) : '' }}</b>
                </div>
                <div class="card-body">
                    @if (isset($document->documentation))
                        {!! $document->documentation !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
