@extends('admin.layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <section class="mt-5 mb-5 pb-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card service-wrapper rounded border-0 shadow">
                    <div class="card-header">
                        <div class="d-flex justify-content-center mb-2"><img src="{{ asset('admin/img/logo.png') }}" class="img-fluid" alt="logo"></div>
                        <h4 class="p-2 pb-0 text-center bold">Reset Password</h4>
                    </div>
                    <div class="card-body p-4">
                        @if(isset($email) && isset($token))
                            <form class="form-horizontal" method="POST" id="resetPasswordForm" name="resetPasswordForm" action="">
                                @csrf
                                <input type="hidden" id="token" name="token" value="{{ $token ?? '' }}">
                                <input type="hidden" id="email" name="email" value="{{ $email ?? '' }}">
                                <div class="col-12 mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" value="">
                                    <div id="passwordError" class="text-danger mt-2"></div>
                                </div>
                                <div class="col-12 mb-4">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password" value="">
                                    <div id="password_confirmationError" class="text-danger mt-2"></div>
                                </div>  
                                <div id="generalError" class="col-12 mb-2 mt-2 text-danger mt-2"></div>
                                <button type="submit" id="reset_password_submit" class="btn btn-primary w-100 pt-3 pb-3 mb-3">Reset Password</button>
                                <div class="col-md-12 text-center">
                                    <p><a class="mt-3 text-dark" href="{{ route('admin.login')}}">Back To Login</a></p>
                                </div>
                            </form>
                        @else
                            <div class="col-md-12 text-center mb-4">
                                <div class="alert alert-danger" role="alert">
                                    {{ $message ?? 'The link is invalid or expired.' }}
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <p><a class="mt-3 text-dark" href="{{ route('admin.login')}}">Back To Login</a></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @include('admin.pages.auth.script.auth-js')   
@endpush

