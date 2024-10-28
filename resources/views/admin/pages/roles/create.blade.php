@extends('admin.layouts.master')

@section('title', 'Roles')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 bold mt-4">Add Role</h1>
    </div>
    @if(isset($permissions) && !empty($permissions) && $permissions->count() > 0)
    <!-- Content Row -->
        <form method="POST" id="roleForm" name="roleForm" action="" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3 text-danger commonFormError"></div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="small mb-1">Role Name:</label>
                                            <input class="form-control" type="text" id="name" name="name" placeholder="" value="{{ old('name', $row->name ?? '')}}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="mb-4">Permissions</h3>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Group Name</th>
                                                            <th>Permissions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($permissions->groupBy('group') as $group => $groupPermissions)
                                                            <tr>
                                                                <td>
                                                                    <span class="form-check">
                                                                        <input class="form-check-input group-select" type="checkbox" id="select-{{ Str::slug($group) }}">
                                                                        <label class="form-check-label" for="select-{{ Str::slug($group) }}">{{ $group }}</label>
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    @foreach($groupPermissions as $permission)
                                                                        <span class="form-check me-2">
                                                                            <input class="form-check-input" type="checkbox" id="permission-{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}"
                                                                            {{ (isset($row) && $row->permissions->contains($permission->id)) ? 'checked' : '' }}>
                                                                            <label class="form-check-label" for="permission-{{ $permission->id }}">{{ $permission->display_name }}</label>
                                                                        </span>
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 mt-4 text-right">
                                            @if(isset($row) && !empty($row))
                                                <button type="submit" id="updateBtn" name="updateBtn" class="btn btn-primary">Update</button>
                                            @else
                                                <button type="submit" id="submitBtn" name="submitBtn" class="btn btn-primary">Submit</button>
                                            @endif
                                            <a href="{{ route('admin.roles.listing') }}" class="btn btn-outline-dark">Cancel</a>
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
                There is some issue with the permissions of the application, please contact the administrator.
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
        submitAjaxForm(formId, "{{ route('admin.roles.store') }}", commonData);
    });

    @if(isset($row) && !empty($row))
    $(document).on('click', '#updateBtn', function(e) {
        e.preventDefault();

        // Find the form associated with the submit button
        let formId = $(this).closest('form').attr('id');
        // Example of appending dynamic common data
        let commonData = {};
        // Call the submit function dynamically based on form ID
        submitAjaxForm(formId, "{{ route('admin.roles.update', ['id' => $row->id]) }}", commonData);
    });
    @endif

    // Group Select All / Unselect All functionality
    $(document).on('click', '.group-select', function() {
        let isChecked = $(this).is(':checked');
        // Select/Deselect all permissions in the same group
        $(this).closest('tr').find('input[name="permissions[]"]').prop('checked', isChecked);
    });
</script>
<script src="{{ asset('admin/js/submitAjaxForm.js') }}"></script>
@endpush
