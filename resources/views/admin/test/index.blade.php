@extends('admin.layouts.master', ['pageSlug' => 'test'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            @livewire('LivewireTest')
        </div>
    </div>
@endsection
