function submitAjaxForm(formId, url, commonData = {}) {
    let form = $(`#${formId}`);
    let formData = new FormData(form[0]); // Make sure to pass the form[0] correctly

    // Append common data to FormData
    for (let key in commonData) {
        if (commonData.hasOwnProperty(key)) {
            formData.append(key, commonData[key]);
        }
    }
    
    $.ajax({
        url: url,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            clearErrors(formId);
        },
        success: function (response, textStatus, xhr) {
            if(xhr.status == 200 && textStatus=='success') {
                clearErrors(formId); // Clear the form
                displaySuccessMessage(response.message,response.redirect_url);  // Display success message
                
            }else{
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
}
function displayErrors(formId, errors) {
    Swal.fire({
        title: 'Error!',
        text: 'Please correct the errors and try again.',
        icon: 'error',
        confirmButtonText: 'OK',
        timer: 3000,
        timerProgressBar: true,
    });
    var commonErrorClass = $("#" + formId + 'Error');
    // Clear previous error messages
    $(commonErrorClass).html('');
    $('.commonFormError').html('');

    
    // Loop through errors and display them near the fields
    for (let field in errors) {
        if (errors.hasOwnProperty(field)) {
            let errorMessage = errors[field][0];
            let $field = $(`#${field}`);
            if ($field.length > 0) {
                $field.addClass('is-invalid');  // Add Bootstrap error class
                $field.siblings('.invalid-feedback').html(errorMessage).show(); // Display error message near the field
            } else {
                 
                if(commonErrorClass.length > 0) {
                    $(commonErrorClass).html(errorMessage).show();
                    setTimeout(function() {
                        $(commonErrorClass).fadeOut(); 
                    }, 35000);
                } else {
                    $('.commonFormError').html(errorMessage).show();
                    setTimeout(function() {
                        $('.commonFormError').fadeOut(); 
                    }, 35000);
                }
            }
        } 
    }
}
function clearErrors(formId) {
    // Clear previous error messages
    $(`#${formId} .invalid-feedback`).html('').hide(); 
    
    // Remove invalid class from all fields
    $(`#${formId} .form-control`).removeClass('is-invalid');
}
function displaySuccessMessage(message,redirect_url) {
    Swal.fire({
        title: 'Success!',
        text: message,
        icon: 'success',
        confirmButtonText: 'OK',
        timer: 3000,
        timerProgressBar: true,
    }).then(() => {
        // Ensure redirection in case the user clicks 'OK'
        window.location.href = redirect_url;
    });
}


