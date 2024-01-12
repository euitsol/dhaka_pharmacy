@extends('admin.layouts.master', ['pageSlug' => 'posts'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            @livewire('posts')
        </div>
    </div>
@endsection






