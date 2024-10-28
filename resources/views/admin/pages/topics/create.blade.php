@extends('admin.layouts.master')

@section('title', 'Topics')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 bold mt-4">Add Topic</h1>
    </div>
    <!-- Content Row -->
    <form method="POST" id="topicForm" name="topicForm" action="" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3 text-danger commonFormError"></div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="small mb-1">Product Type</label>
                                        <x-product-type-component :selectedValue="old('product_type_id', $row->product_type_id ?? '')" :isShowEmptyMessage="true"/>
                                         <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="small mb-1">Category</label>
                                        <select class="form-control" id="category_id" name="category_id">
                                            <option value="">Select Category</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="small mb-1">Topic Name</label>
                                        <input class="form-control" type="text" id="name" name="name" placeholder="" value="{{ old('name', $row->name ?? '')}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 mt-4">
                                        @if(isset($row) && !empty($row))
                                            <button type="submit" id="updateBtn" name="updateBtn" class="btn btn-primary w-100">Update</button>
                                        @else
                                            <button type="submit" id="submitBtn" name="submitBtn" class="btn btn-primary w-100">Submit</button>
                                        @endif
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 mt-4">
                                        <a href="{{ route('admin.topics.listing') }}" class="btn btn-outline-dark w-100">Cancel</a>
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
        // Example of appending dynamic common data
        let commonData = {};
        // Call the submit function dynamically based on form ID
        submitAjaxForm(formId, "{{ route('admin.topics.store') }}", commonData);
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
    submitAjaxForm(formId, "{{ route('admin.topics.update', ['id' => $row->id]) }}", commonData);

});
</script>
@endif
@include('admin.scripts.product-type-wise-categories-js',[
    'selectedCategoryId' => old('category_id', $row->category_id ?? ''),
    'selectedProductTypeId' => old('product_type_id', $row->product_type_id ?? ''),
    ])
<script src="{{ asset('admin/js/submitAjaxForm.js') }}"></script>
@endpush
