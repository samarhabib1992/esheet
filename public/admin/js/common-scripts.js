function confirmDelete(type,id,url) {
    Swal.fire({
        title: `Are you sure you want to delete this?`,
        text: `You won't be able to revert this!`,
        icon: "warning",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: "Yes, Delete it!",
        cancelButtonText: 'No, Cancel!',
        customClass: {
            confirmButton: "btn btn-danger m-1",
            cancelButton: 'btn btn-secondary m-1'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            commonDeleteRecord(type, id,url);
        }
    });
}
function commonDeleteRecord(type, id, url) {
    $.ajax({
        url: url,
        type: 'DELETE',
        data: JSON.stringify({ id: id }), // Pass the ID in the request body as JSON
        dataType: 'json',
        contentType: 'application/json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
        },
        success: function (response, textStatus, xhr) {
            if (textStatus === 'success') {
                Swal.fire({
                    title: 'Success!',
                    text: response.message || 'Record deleted successfully!', // Ensure `message` is returned from the backend
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 3000,
                    timerProgressBar: true,
                }).then(() => {
                    location.reload(); // Reload page after success
                });
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
        },
        error: function (xhr, status, error) {
            Swal.fire({
                title: 'Error!',
                text: 'An unexpected error occurred. Please refresh the page and try again.',
                icon: 'error',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
            });
        }
    });
}


$(document).on('input paste', '.number-input', function(evt) {
    var inputValue = evt.target.value;
    var clipboardData = evt.originalEvent.clipboardData || window.clipboardData;
    var pastedValue = clipboardData && clipboardData.getData('text');

    var validInput = /^-?\d*$/.test(inputValue);

    if (!validInput) {
        evt.target.value = inputValue.replace(/[^-\d]/g, '');
        return;
    }

    if (pastedValue) {
        var validPastedInput = /^-?\d*$/.test(pastedValue);

        if (!validPastedInput) {
            evt.preventDefault();
        }
    }
});
$(document).on('keypress', '.floating-inputs', function(evt) {
    var charCode = evt.which ? evt.which : evt.keyCode;
    var charCode = evt.which ? evt.which : evt.keyCode;
    var inputValue = evt.target.value;
    var decimalCount = (inputValue.match(/\./g) || []).length;
    if (charCode !== 46 && charCode !== 45 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else if (charCode === 46 && decimalCount >= 1) {
        return false;
    } else if (decimalCount === 1 && inputValue.split('.')[1].length >= 2) {
        return false;
    } else {
        return true;
    }
});