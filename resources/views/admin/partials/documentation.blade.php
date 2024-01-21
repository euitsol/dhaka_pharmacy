@if(isset($document->title))
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <p class="card-header">
                    <b>{{ ucfirst($document->title)}}</b>
                </p>
                <div class="card-body">
                    {!! $document->documentation !!}
                </div>
            </div>
        </div>
    </div>
@endif