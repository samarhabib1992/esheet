@extends('front.layouts.main')

@section('title', 'About Us')

@section('content')
    @include('front.partials._slider', ['sliderPageTitle' => 'About Us'])
    <section class="ms-about mt-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-12">
                    <div class="ms-about-img">
                        <img src="{{asset('assets/img/about.png')}}" alt="about" width="100%">
                    </div>
                </div>
                <div class="col-xl-6 col-md-12">
                    <div class="ms-about-detail">
                        <div class="section-title">
                            <h2 class="title " style="font-weight: 700;">About <span>CloudSpinx</span></h2>
                            <p>We're here to serve only the best products for you. Enriching your homes with the best essentials.</p>
                        </div>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        <p>Lorem Ipsum has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('front.partials._why_our_products') 
@endsection
@push('scripts')
 
@endpush
