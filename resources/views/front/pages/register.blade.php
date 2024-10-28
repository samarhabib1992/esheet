@extends('front.layouts.main')

@section('title', 'Register')

@section('content')

<section class="mt-5 mb-5 pb-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card service-wrapper rounded border-0 shadow">
                <div class="card-header">
                    <h4 class=" p-2 pb-0" style="font-weight: bold;">Register Your Account</h4>
                </div>
                <div class="card-body  p-4">
                    <form>
                       <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="exampleInputEmail1">
                              </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" >
                              </div>
                        </div>
                       </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Email</label>
                          <input type="email" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Mobile</label>
                            <input type="number" class="form-control" id="exampleInputPassword1">
                          </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1">
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1">
                                  </div>
                            </div>
                           </div>
                        <button type="submit" class="btn btn-primary w-100 pt-3 pb-3 mb-3">Register</button>
                        <div class="col-md-12 text-center">
                            <p>Already have an account?<a class="mt-3 text-dark" href="{{ route('login')}}"> Login</a></p>
                        </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
@endpush
