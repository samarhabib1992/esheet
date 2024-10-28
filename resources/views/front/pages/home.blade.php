@extends('front.layouts.main')

@section('title', 'eSheet')

@section('content')
    @include('front.partials._unlock_it_potential')
    @include('front.partials._why_our_products') 
    @include('front.partials._category_highlights') 
    @include('front.partials._learning_materials')  
    @include('front.partials._latest_news')
@endsection
@push('scripts')
@endpush
