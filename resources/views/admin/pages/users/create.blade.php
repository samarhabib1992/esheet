@extends('admin.layouts.master')

@section('title', 'Users')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 bold mt-4">Add User</h1>
    </div>
    <!-- Content Row -->
    @if($roles->isNotEmpty())
        <form method="POST" id="userForm" name="userForm" action="" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3 text-danger commonFormError"></div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="small mb-1">Role</label>
                                            <select class="form-control" id="role_id" name="role_id">
                                                <option value="">Select Role</option>
                                                @foreach($roles as $role)
                                                    <option value="{{$role->id}}" {{ old('role_id', $row->role_id?? '') == $role->id?'selected' : '' }}>{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1">First Name</label>
                                            <input class="form-control" type="text" id="first_name" name="first_name" placeholder="" value="{{ old('first_name', $row->first_name ?? '')}}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1">Last Name</label>
                                            <input class="form-control" type="text" id="last_name" name="last_name" placeholder="" value="{{ old('last_name', $row->last_name ?? '')}}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="small mb-1">Mobile</label>
                                            <input class="form-control" type="text" id="mobile_number" name="mobile_number" placeholder="" value="{{ old('mobile_number', $row->mobile_number ?? '')}}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1">Email</label>
                                            <input class="form-control" type="text" id="email" name="email" placeholder="" value="{{ old('email', $row->email ?? '')}}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1">Password</label>
                                            <input class="form-control" type="password" id="password" name="password" placeholder="" value="">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="small mb-1">Confirm Password</label>
                                            <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" placeholder="" value="">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-md-6 mb-3">&nbsp;</div>
                                        <div class="col-md-6 mt-4">
                                            @if(isset($row) && !empty($row))
                                                <button type="submit" id="updateBtn" name="updateBtn" class="btn btn-primary w-100">Update</button>
                                            @else
                                                <button type="submit" id="submitBtn" name="submitBtn" class="btn btn-primary w-100">Submit</button>
                                            @endif
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <a href="{{ route('admin.users.listing') }}" class="btn btn-outline-dark w-100">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="categoryImage">Profile Picture</label>
                                        <div class="file-upload" onclick="document.getElementById('image').click();">
                                            <p>Drag and drop a file to upload</p>
                                            <input type="file" id="image" name="image" style="display:none;">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="uploaded-file" id="uploadedFile" style="display:none;">
                                            <img src="" alt="Uploaded File">
                                            <div class="file-info">
                                                <div class="file-name">Filename.jpg</div>
                                                <div class="file-size">100 KB</div>
                                            </div>
                                            <div class="remove-file" onclick="removeFile()">×</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('admin.roles.add') }}">Please  Add Role First to Continue</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).on('click', '#submitBtn', function(e) {
        e.preventDefault();

        // Find the form associated with the submit button
        let formId = $(this).closest('form').attr('id');
        // Example of appending dynamic common data
        let commonData = {};
        // Call the submit function dynamically based on form ID
        submitAjaxForm(formId, "{{ route('admin.users.store') }}", commonData);
    });
</script>
@if(isset($row) && !empty($row))
<script type="text/javascript">
$(document).on('click', '#updateBtn', function(e) {
        e.preventDefault();

        // Find the form associated with the submit button
        let formId = $(this).closest('form').attr('id');
        // Example of appending dynamic common data
        let commonData = {};
        // Call the submit function dynamically based on form ID
        submitAjaxForm(formId, "{{ route('admin.users.update', ['id' => $row->id]) }}", commonData);

    });
</script>
@endif
<script src="{{ asset('admin/js/imageupload.js') }}"></script>
<script src="{{ asset('admin/js/submitAjaxForm.js') }}"></script>

@endpush
