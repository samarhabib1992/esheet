@extends('admin.layouts.master')

@section('title', 'Products')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 bold mt-4">Add Product</h1>
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
                            <h6 class="bold">Product Images</h6>
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
                            <div class="col-12 mt-4">
                                <label class="small mb-1">Description</label>
                                <div id="editor" class="form-control"></div>
                                <textarea id="editor-content" name="content" style="display: none;"> {{ old('description', $row->description ?? '') }}</textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1">Product Name</label>
                                    <input class="form-control" type="text" id="name" name="name" placeholder="" value="{{ old('name', $row->name ?? '')}}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1">Product Type</label>
                                    <x-product-type-component :selectedValue="old('product_type_id', $row->product_type_id ?? '')" :isShowEmptyMessage="true"/>
                                     <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1">Category</label>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Select Category</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1">Topic</label>
                                    <select class="form-control" id="topic_id" name="topic_id">
                                        <option value="">Select Topic</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="small mb-1">Price</label>
                                    <input class="form-control floating-inputs" id="price" name="price" type="text" placeholder="" value="{{ old('price', $row->price ?? '')}}">
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
@include('admin.scripts.editor')
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

        // Retrieve the markdown content
        var markdownContent = editor.getMarkdown(); // Ensure editor instance is used here
        formData.append('description', markdownContent);  // Append editor content as 'content'

        // Now you can proceed with AJAX submission
        $.ajax({
            url: "{{ route('admin.products.store') }}",
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
        
        // Retrieve the markdown content
        var markdownContent = editor.getMarkdown(); // Ensure editor instance is used here
        formData.append('description', markdownContent);  // Append editor content as 'content'

        // Now you can proceed with AJAX submission
        $.ajax({
            url: "{{ route('admin.products.update', ['id' => $row->id]) }}",
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
@include('admin.scripts.product-type-wise-categories-js',[
    'selectedCategoryId' => old('category_id', $row->category_id ?? ''),
    'selectedProductTypeId' => old('product_type_id', $row->product_type_id ?? ''),
    ])
@include('admin.scripts.category-wise-topics-js',[
    'selectedTopicId' => old('topic_id', $row->topic_id ?? ''),
    'selectedCategoryId' => old('category_id', $row->category_id ?? ''),
])
@include('admin.scripts._multiple_file_upload_js')
<script src="{{ asset('admin/js/submitAjaxForm.js') }}"></script>
@endpush
