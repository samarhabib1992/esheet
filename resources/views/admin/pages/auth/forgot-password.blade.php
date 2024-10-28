@extends('admin.layouts.auth')

@section('title', 'Forgot Password')

@section('content')
    <section class="mt-5 mb-5 pb-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card service-wrapper rounded border-0 shadow">
                    <div class="card-header">
                        <div class="d-flex justify-content-center mb-2"><img src="{{ asset('admin/img/logo.png') }}" class="img-fluid" alt="logo"></div>
                        <h4 class="p-2 pb-0 text-center bold">Forgot Password</h4>
                    </div>
                    <div class="card-body p-4">
                        <form class="form-horizontal" method="POST" id="forgotPasswordForm" name="forgotPasswordForm" action="">
                                <div class="col-12 mb-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" id="email" name="email" class="form-control" aria-describedby="email" placeholder="Email" value="">
                                    <div id="emailError" class="text-danger mt-2"></div>
                                </div>  
                              <div id="generalError" class="col-12 mb-2 mt-2 text-danger mt-2"></div>
                              <button type="submit" id="forgot_password_submit" class="btn btn-primary w-100 pt-3 pb-3 mb-3">Reset Password</button>
                              <div class="col-md-12 text-center">
                                  <p><a class="mt-3 text-dark" href="{{ route('admin.login')}}">Back To Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @include('admin.pages.auth.script.auth-js')   
@endpush

