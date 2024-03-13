@extends('frontend.layouts.master')
@section('title', 'Home')

@section('content')
    <div class="row pt-4">
        <!--===========  Sidebar-Category-Section-Include ==============-->
        @if ($menuItems->isNotEmpty())
            @include('frontend.includes.home.sidebar', ['menuItems' => $menuItems])
        @endif
        <!--=========== Sidebar-Category-Section-Include  ==============-->

    </div>
@endsection

