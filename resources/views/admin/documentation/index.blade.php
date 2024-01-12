@extends('admin.layouts.master', ['pageSlug' => 'documentation'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            @livewire('Documentation')
        </div>
    </div>
@endsection
