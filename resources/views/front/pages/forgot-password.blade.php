@extends('front.layouts.main')

@section('title', 'Register')

@section('content')
<section class="mt-5 mb-5 pb-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card service-wrapper rounded border-0 shadow">
                <div class="card-header">
                    <h4 class=" p-2 pb-0" style="font-weight: bold;">Forgot Your Password</h4>
                </div>
                <div class="card-body  p-4">
                    <form>
                        <div class="mb-4">
                          <label for="exampleInputEmail1" class="form-label">Email address</label>
                          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 pt-3 pb-3 mb-3">Submit</button>
                        <div class="col-md-12 text-center">
                            <p>Already have an account?<a class="mt-3 text-dark" href="{{ route('login')}}"> Login</a></p>
                        </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
</section>
</section>
@endsection
@push('scripts')
@endpush
