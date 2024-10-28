@extends('admin.layouts.auth')

@section('title', 'Login')

@section('content')
    <section class="mt-5 mb-5 pb-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card service-wrapper rounded border-0 shadow">
                    <div class="card-header">
                        <div class="d-flex justify-content-center mb-2"><img src="{{ asset('admin/img/logo.png') }}" class="img-fluid" alt="logo"></div>
                        <h4 class="p-2 pb-0 text-center bold">Login To Your Account</h4>
                    </div>
                    <div class="card-body p-4">
                        <form class="form-horizontal" method="POST" id="loginForm" name="loginForm" action="">
                            <div class="col-12 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" id="email" name="email" class="form-control" aria-describedby="email" placeholder="Email" value="{{ old('email', $credentials['email'] ?? '') }}">
                                <div id="emailError" class="text-danger mt-2"></div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" value="{{ old('email', $credentials['password'] ?? '') }}">
                                <div id="passwordError" class="text-danger mt-2"></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" id="remember" name="remember" value="1" class="form-check-input" {{ old('remember', $credentials['remember'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">Rember Me</label>
                                    </div>
                                    <div id="rememberError" class="text-danger mt-2"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 form-check" style="text-align: end;">
                                    <a href="{{ route('admin.forgot-password.form')}}" class="text-dark">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                            <div id="generalError" class="col-12 mb-2 mt-2 text-danger mt-2"></div>
                            <button type="submit" id="login_form_submit" class="btn btn-primary w-100 pt-3 pb-3 mb-3">Login</button>
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

