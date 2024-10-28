@extends('admin.layouts.master')

@section('title', 'Setting')
@section('content')
    <div class="container-fluid">
        <div class="row align-items-center mt-5">
            <div class="col-md-8">
                <h1 class="h3 mb-0 text-gray-800 bold">General Setting</h1>
            </div>
        </div>

        <div class="accordion" id="settingsAccordion">
            <!-- Edit Profile Section -->
            <div class="card card shadow mb-4 mt-4">
                <div class="row p-3 ml-2 ">
                    <button class="btn btn-primary bold m-1 p-1" type="button" aria-expanded="true" data-toggle="collapse" data-target="#defaultSetting">Basic Setting</button>                                
                    <button class="btn btn-primary bold m-1 p-1" type="button" aria-expanded="false" data-toggle="collapse" data-target="#smtpSetting">SMTP Setting</button>
                    <button class="btn btn-primary bold m-1 p-1" type="button" aria-expanded="false" data-toggle="collapse" data-target="#testEmail">Test Email</button>
                </div>
                <!-- Default Setting Section -->
                <div class="collapse show" id="defaultSetting">
                    <div class="card-body">
                        <form method="POST" id="websiteForm" name="websiteForm" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3 text-danger websiteFormError"></div>
                                <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Company Name</label>
                                        <input class="form-control" type="text" id="company_name" name="company_name" placeholder="" value="{{ old('company_name', $row->company_name ?? '')}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Phone Number</label>
                                        <input class="form-control" type="text" id="phone_number" name="phone_number" placeholder="" value="{{ old('phone_number', $row->phone_number ?? '')}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Mobile Number</label>
                                        <input class="form-control" type="text" id="mobile_number" name="mobile_number" placeholder="" value="{{ old('mobile_number', $row->mobile_number ?? '')}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Email</label>
                                        <input class="form-control" type="text" id="email" name="email" placeholder="" value="{{ old('email', $row->email ?? '')}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Facebook</label>
                                        <input class="form-control" type="text" id="facebook" name="facebook" placeholder="https://facebook.com" value="{{ old('facebook', $row->facebook ?? '')}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Twitter</label>
                                        <input class="form-control" type="text" id="twitter" name="twitter" placeholder="https://twitter.com" value="{{ old('twitter', $row->twitter ?? '')}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Pinterest</label>
                                        <input class="form-control" type="text" id="pinterest" name="pinterest" placeholder="https://pinterest.com" value="{{ old('pinterest', $row->pinterest ?? '')}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Skype</label>
                                        <input class="form-control" type="text" id="skype" name="skype" placeholder="https://skype.com" value="{{ old('skype', $row->skype ?? '')}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Address</label>
                                        <textarea class="form-control" type="text" id="address" name="address" placeholder="">{{ old('address', $row->address ?? '')}}</textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Upload Logo</label>
                                        <input class="form-control" type="file" id="logo" name="logo">
                                        <div class="invalid-feedback"></div>
                                        @if(isset($row) && !empty($row) && !empty($row->logo))
                                            <div class="col-md-3">
                                                <img src="{{ asset('storage/uploads/logo/'.$row->logo) }}" class="img-fluid w-100" alt="logo">
                                            </div>
                                        @endif
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
    
                <!-- Smtp Section -->
                <div class="collapse " id="smtpSetting">
                    <div class="card-body">
                        <form method="POST" id="smtpForm" name="smtpForm" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3 text-danger smtpFormError"></div>
                                <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Smpt Host</label>
                                        <input class="form-control" type="text" id="smtp_mail_host" name="smtp_mail_host" placeholder="" value="{{ old('smtp_mail_host', $row->smtp_mail_host ?? '')}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Smtp Port</label>
                                        <input class="form-control" type="text" id="smtp_mail_port" name="smtp_mail_port" placeholder="" value="{{ old('smtp_mail_port', $row->smtp_mail_port ?? '')}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Smtp Username</label>
                                        <input class="form-control" type="text" id="smtp_mail_username" name="smtp_mail_username" placeholder="" value="{{ old('smtp_mail_username', $row->smtp_mail_username ?? '')}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Smtp Password</label>
                                        <input class="form-control" type="password" id="smtp_mail_password" name="smtp_mail_password" placeholder="" value="{{ old('smtp_mail_password', $row->smtp_mail_password ?? '')}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Smtp from Name</label>
                                        <input class="form-control" type="text" id="smtp_mail_from_name" name="smtp_mail_from_name" placeholder="" value="{{ old('smtp_mail_from_name', $row->smtp_mail_from_name ?? '')}}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Smtp from Email</label>
                                        <input class="form-control" type="text" id="smtp_mail_from_address" name="smtp_mail_from_address" placeholder="" value="{{ old('smtp_mail_from_address', $row->smtp_mail_from_address ?? '')}}">
                                        <div class="invalid-feedback"></div>
                                    </div> 
                                    <div class="col-md-9"></div>
                                    <div class="col-md-3">
                                        <div class="text-right">
                                            <button type="submit" id="submitSmtpBtn" name="submitSmtpBtn" class="btn btn-primary w-100">Save Smtp Setting</button>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
                <!-- Send Test Email Section -->
                <div class="collapse " id="testEmail">
                    <div class="card-body">
                        <form method="POST" id="testEmailForm" name="testEmailForm" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3 text-danger testEmailFormError"></div>
                                <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Test Email</label>
                                        <input class="form-control" type="text" id="test_email" name="test_email" placeholder="" value="{{ old('test_email') }}">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-9"></div>
                                    <div class="col-md-3">
                                        <div class="text-right">
                                            <button type="submit" id="sendEmailBtn" name="sendEmailBtn" class="btn btn-primary w-100">Send Test Email</button>
                                        </div>
                                    </div>
                                </div>
                                </div>
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
        submitAjaxForm(formId, "{{ route('admin.setting.store.default') }}", commonData);
    });
    $(document).on('click', '#submitSmtpBtn', function(e) {
        e.preventDefault();

        // Find the form associated with the submit button
        let formId = $(this).closest('form').attr('id');
        // Example of appending dynamic common data
        let commonData = {};
        // Call the submit function dynamically based on form ID
        submitAjaxForm(formId, "{{ route('admin.setting.store.smtp') }}", commonData);
    });
    $(document).on('click', '#sendEmailBtn', function(e) {
        e.preventDefault();

        // Find the form associated with the submit button
        let formId = $(this).closest('form').attr('id');
        // Example of appending dynamic common data
        let commonData = {};
        // Call the submit function dynamically based on form ID
        submitAjaxForm(formId, "{{ route('admin.setting.send_test_email') }}", commonData);
    });
    $(document).ready(function () {
        // When a collapsible button is clicked
        $('[data-toggle="collapse"]').on('click', function () {
            var target = $(this).data('target');

            // Hide all other collapsible content except the current one
            $('.collapse').not(target).collapse('hide');
        });
    });
</script>
<script src="{{ asset('admin/js/submitAjaxForm.js') }}"></script>
@endpush
