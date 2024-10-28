@extends('admin.layouts.master')

@section('title', 'Blog Post')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 bold mt-4">Add Blog Post</h1>
    </div>
    <!-- Content Row -->
    <form method="POST" id="productForm" name="productForm" action="" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                       <div class="row">
                        <div class="col-md-6">
                            <h6 class="bold">Post Images</h6>
                            <div class="card shadow mb-4">
                                <div class="card-body text-center">
                                    <!-- Image preview container -->
                                    <div id="imagePreview" class="d-flex flex-wrap justify-content-center">
                                        <img src="{{ asset('admin/img/3-icon.png')}}" width="40%" alt="" id="defaultImage">
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mt-4">
                                 <!-- Hidden File Input -->
                                <input type="file" id="fileInput" name="images[]" style="display:none;" multiple>
                                <a href="javascript:void(0);" class="upload-text bold" onclick="triggerFileUpload();">Upload more images <i class="fas fa-upload"></i></a>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group mt-4">
                                <label class="small mb-1">Content</label>
                                <textarea name="content" class="form-control" rows="3" id="content"> {{ old('content', $row->content ?? '') }}</textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1">Title</label>
                                    <input class="form-control" type="text" id="title" name="title" placeholder="" value="{{ old('title', $row->title ?? '')}}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1">Slug</label>
                                    <input class="form-control" type="text" id="slug" name="slug" placeholder="" value="{{ old('slug', $row->slug ?? '')}}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1">Author Naame</label>
                                    <input class="form-control" type="text" id="author_name" name="author_name" placeholder="" value="{{ old('author_name', $row->author_name ?? '')}}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1">Category</label>
                                    <x-blog-category-dropdown :selectedCategory="old('category_id', $row->category_id ?? '')" :isShowEmptyMessage="true"/>
                                     <div class="invalid-feedback"></div>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1">Short Description</label>
                                    <textarea name="short_description" class="form-control" rows="3" id="short_description"> {{ old('short_description', $row->short_description ?? '') }}</textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1">Tags(Comma Separated values)</label>
                                    <textarea name="tags" class="form-control" rows="3" id="tags"> {{ old('tags', $row->tags ?? '') }}</textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-6 mt-4">
                                    @if(isset($row) && !empty($row))
                                        <button type="submit" id="updateBtn" name="updateBtn" class="btn btn-primary w-100">Update</button>
                                    @else
                                        <button type="submit" id="submitBtn" name="submitBtn" class="btn btn-primary w-100">Submit</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).on('click', '#submitBtn', function(e) {
        e.preventDefault();

        // Find the form associated with the submit button
        let formId = $(this).closest('form').attr('id');
        let formData = new FormData();

        // Check if uploadedFiles is not empty
        if (uploadedFiles.length > 0) {
            // Append only the remaining uploadedFiles to the formData
            uploadedFiles.forEach((file, index) => {
                formData.append('images[]', file);
            });
        }

        // Add any other form fields if necessary
        let formFields = $(`#${formId}`).serializeArray();
        formFields.forEach(function(field) {
            formData.append(field.name, field.value);
        });

        // Now you can proceed with AJAX submission
        $.ajax({
            url: "{{ route('admin.blog.store') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                clearErrors(formId);
            },
            success: function (response, textStatus, xhr) {
                if(xhr.status == 200 && textStatus == 'success') {
                    clearErrors(formId); // Clear the form
                    displaySuccessMessage(response.message, response.redirect_url);  // Display success message
                } else {
                    displayErrors(formId, response.message);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422 || xhr.status === 429) {
                    let errors = xhr.responseJSON.errors;
                    displayErrors(formId, errors);  // Display validation errors
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An unexpected error occurred. Please refresh the page and try again.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            }
        });
    });
</script>
@if(isset($row) && !empty($row))
    <script type="text/javascript">
    $(document).on('click', '#updateBtn', function(e) {
        e.preventDefault();

        // Find the form associated with the submit button
        let formId = $(this).closest('form').attr('id');
        let formData = new FormData();

        // Check if uploadedFiles is not empty
        if (uploadedFiles.length > 0) {
            // Append only the remaining uploadedFiles to the formData
            uploadedFiles.forEach((file, index) => {
                formData.append('images[]', file);
            });
        }

        // Add any other form fields if necessary
        let formFields = $(`#${formId}`).serializeArray();
        formFields.forEach(function(field) {
            formData.append(field.name, field.value);
        });

        // Now you can proceed with AJAX submission
        $.ajax({
            url: "{{ route('admin.blog.update', ['id' => $row->id]) }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                clearErrors(formId);
            },
            success: function (response, textStatus, xhr) {
                if(xhr.status == 200 && textStatus == 'success') {
                    clearErrors(formId); // Clear the form
                    displaySuccessMessage(response.message, response.redirect_url);  // Display success message
                } else {
                    displayErrors(formId, response.message);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422 || xhr.status === 429) {
                    let errors = xhr.responseJSON.errors;
                    displayErrors(formId, errors);  // Display validation errors
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An unexpected error occurred. Please refresh the page and try again.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        timer: 3000,
                        timerProgressBar: true,
                    });
                }
            }
        });
    });
    </script>
@endif
@include('admin.scripts._multiple_file_upload_js')
<script src="{{ asset('admin/js/submitAjaxForm.js') }}"></script>
@endpush
