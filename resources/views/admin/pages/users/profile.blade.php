@extends('admin.layouts.master')

@section('title', 'Settings')
@section('content')
<div class="container-fluid">
    <div class="row align-items-center mt-5">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800 bold">Settings</h1>
        </div>
       
       </div>

    <div class="accordion" id="settingsAccordion">
        <!-- Edit Profile Section -->
        <div class="card card shadow mb-4 mt-4">
         <div class="row p-3 ml-2 ">
            <div class="col-md-2">
                <button class="btn btn-primary w-100 bold" type="button" style="font-size: 12px;" aria-expanded="true" data-toggle="collapse" data-target="#collapseExample">Edit Profile</button>                                
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100 bold" type="button" style="font-size: 12px;" aria-expanded="false" data-toggle="collapse" data-target="#collapseExample2">Security</button>
            </div>
         </div>
     
      
        <div class="collapse show" id="collapseExample">
        
            <div class="card-body">
                <form method="POST" id="userForm" name="userForm" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-3 text-danger commonFormError"></div>
                        <div class="col-md-2 position-relative">
                            <a href="javascript:void(0)" onclick="triggerFileInput();">
                                <img id="profileImage" src="{{ asset('admin/img/undraw_profile.svg') }}" class="img-profile rounded-circle" alt="Profile Image" style="width:50%; height: 50%;">
                            </a>
                            <input type="file" id="image" name="image" accept="image/*" style="display:none;" onchange="triggerFileInput();">
                        
                            <!-- Delete Icon -->
                            <span id="deleteIcon" onclick="removeImage();" style="display:none; cursor: pointer; position: absolute; top: 0; right: 0; background: red; color: white; padding: 5px;">
                                &times;
                            </span>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-10">
                         <div class="row">
                            <div class="form-group col-md-6">
                                <label>First Name</label>
                                <input class="form-control" type="text" id="first_name" name="first_name" placeholder="" value="{{ old('first_name', $row->first_name ?? '')}}">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Last Name</label>
                                <input class="form-control" type="text" id="last_name" name="last_name" placeholder="" value="{{ old('last_name', $row->last_name ?? '')}}">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Mobile</label>
                                <input class="form-control" type="text" id="mobile_number" name="mobile_number" placeholder="" value="{{ old('mobile_number', $row->mobile_number ?? '')}}">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input class="form-control" type="text" id="email" name="email" placeholder="" value="{{ old('email', $row->email ?? '')}}">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Password</label>
                                <input class="form-control" type="password" id="password" name="password" placeholder="" value="">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Confirm Password</label>
                                <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" placeholder="" value="">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <div class="text-right">
                                    <button type="submit" id="submitBtn" name="submitBtn" class="btn btn-primary w-100">Save</button>
                                </div>
                            </div>
                         </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
   
        <!-- Security Section -->
        <div class="collapse " id="collapseExample2">
            <div class="card-body">
                <form>
                    <h5>Two-factor Authentication</h5>
                    <div class="form-group mt-4">
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider round"></span>
                        </label>
                        <label for="">Enable or disable two factor authentication</label>
                        
                    </div>
                    <div class="form-group">
                        <label>Change Password</label>
                        <input type="password" class="form-control" placeholder="Current Password">
                        <input type="password" class="form-control mt-2" placeholder="New Password">
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
    </div>
</div>
    </div>
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
        submitAjaxForm(formId, "{{ route('admin.users.profile.update') }}", commonData);
    });
    $(document).ready(function () {
        // When a collapsible button is clicked
        $('[data-toggle="collapse"]').on('click', function () {
            var target = $(this).data('target');

            // Hide all other collapsible content except the current one
            $('.collapse').not(target).collapse('hide');
        });
    });
    function triggerFileInput() {
        const fileInput = document.getElementById('image');
        fileInput.click();  // Trigger the file input click

        fileInput.onchange = function(event) {
            const file = event.target.files[0];
            const imgElement = document.getElementById('profileImage');
            const deleteIcon = document.getElementById('deleteIcon');

            // Check if a file is selected and it's an image
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgElement.src = e.target.result;  // Update image src with the selected file
                    deleteIcon.style.display = 'block';  // Show delete icon
                }
                reader.readAsDataURL(file);
            }
        };
    }

    function removeImage() {
        const imgElement = document.getElementById('profileImage');
        const fileInput = document.getElementById('fileInput');
        const deleteIcon = document.getElementById('deleteIcon');

        // Reset the image to the default
        imgElement.src = "{{ asset('admin/img/undraw_profile.svg') }}";  // Default image

        // Hide the delete icon
        deleteIcon.style.display = 'none';

        // Clear the file input
        fileInput.value = '';  // Unset the file input
    }
</script>
<script src="{{ asset('admin/js/submitAjaxForm.js') }}"></script>
@endpush
