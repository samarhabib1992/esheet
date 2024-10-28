<script type="text/javascript">
    let uploadedFiles = [];

    function triggerFileUpload() {
        document.getElementById('fileInput').click();
    }

    document.getElementById('fileInput').addEventListener('change', function(event) {
        const files = event.target.files;
        const imagePreview = document.getElementById('imagePreview');
        //imagePreview.innerHTML = ''; // Clear previous images

        // Check if more than 5 images are selected
        if (files.length > 5) {
            Swal.fire({
                title: 'Warning!',
                text: 'You can only upload a maximum of 5 images!',
                icon: 'warning',
                confirmButtonText: 'OK',
                timer: 2000,
                timerProgressBar: true,
            });
            return;
        }

        // Validate image sizes
        const oversizedFiles = Array.from(files).filter(file => file.size > 5 * 1024 * 1024);
        if (oversizedFiles.length > 0) {
            Swal.fire({
                title: 'Warning!',
                text: 'Each image must be smaller than 5 MB!',
                icon: 'warning',
                confirmButtonText: 'OK',
                timer: 2000,
                timerProgressBar: true,
            });
            return;
        }

        if (files.length > 0) {
            uploadedFiles = [...files]; // Save uploaded files
            displayImages(uploadedFiles);
        } else {
            imagePreview.innerHTML = `<img src="{{ asset('admin/img/3-icon.png')}}" width="40%" alt="" id="defaultImage">`;
        }
    });

    // Function to display images with delete buttons
    function displayImages(files) {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.innerHTML = ''; // Clear the preview

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                // Create a container for each image and delete button
                const imgContainer = document.createElement('div');
                imgContainer.classList.add('position-relative', 'm-2'); // Position container

                const img = document.createElement('img');
                img.src = e.target.result;
                img.width = 150; // Adjust image width
                img.classList.add('img-thumbnail', 'shadow-sm', 'rounded');

                // Create delete button
                const deleteBtn = document.createElement('a');
                deleteBtn.innerHTML = '&times;'; // X symbol for delete
                deleteBtn.classList.add('btn', 'btn-delete-image', 'btn-sm', 'position-absolute');
                deleteBtn.style.top = '5px'; // Position slightly inside the top
                deleteBtn.style.right = '5px'; // Align to the right
                deleteBtn.style.borderRadius = '50%'; // Make button circular
                deleteBtn.style.width = '25px'; // Set width and height for button
                deleteBtn.style.height = '25px';
                deleteBtn.style.padding = '0'; // Remove padding
                deleteBtn.style.lineHeight = '1.4'; // Center text inside the button

                deleteBtn.onclick = function() {
                    confirmDelete(i);
                };

                imgContainer.appendChild(img);
                imgContainer.appendChild(deleteBtn);
                imagePreview.appendChild(imgContainer);
            };

            reader.readAsDataURL(file);
        }
    }

    // Function to confirm delete with swal
    function confirmDelete(index) {
        
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
                deleteImage(index);
            }
        });
    }

    // Function to delete image
    function deleteImage(index) {
        uploadedFiles.splice(index, 1); // Remove the file from the array
        if (uploadedFiles.length === 0) {
            document.getElementById('imagePreview').innerHTML = `<img src="{{ asset('admin/img/3-icon.png')}}" width="40%" alt="" id="defaultImage">`;
        } else {
            displayImages(uploadedFiles); // Re-display remaining images
        }

        Swal.fire({
            title: 'Success!',
            text: 'Image deleted successfully!',
            icon: 'success',
            confirmButtonText: 'OK',
            timer: 2000,
            timerProgressBar: true,
        });
    }
</script>

<!-- Add some custom styles -->
<style>
    #imagePreview {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }
    .img-thumbnail {
        position: relative;
        max-width: 150px;
        max-height: 150px;
    }
    .btn-delete-image {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
        font-size: 16px;
        line-height: 1;
        width: 25px;
        height: 25px;
        background-color: transparent;
        color:#e40f0f;
        font-weight: bold;
        border: none;
        cursor: pointer;
        opacity: 0.5;
    }
</style>
