function triggerFileUpload() {
    document.getElementById('image').click();
}
const image = document.getElementById('image');
const uploadedFile = document.getElementById('uploadedFile');
const imgPreview = uploadedFile.querySelector('img');
const fileName = uploadedFile.querySelector('.file-name');
const fileSize = uploadedFile.querySelector('.file-size');

image.addEventListener('change', function() {
    const file = image.files[0];
    if (file) {
        imgPreview.src = URL.createObjectURL(file);
        fileName.textContent = file.name;
        fileSize.textContent = `${(file.size / 1024).toFixed(1)} KB`;
        uploadedFile.style.display = 'flex';
    }
});

function removeFile() {
    image.value = '';
    uploadedFile.style.display = 'none';
}