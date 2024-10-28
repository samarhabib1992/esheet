function triggerFileUpload() {
    document.getElementById('fileInput').click();
}
const fileInput = document.getElementById('fileInput');
const uploadedFile = document.getElementById('uploadedFile');
const imgPreview = uploadedFile.querySelector('img');
const fileName = uploadedFile.querySelector('.file-name');
const fileSize = uploadedFile.querySelector('.file-size');

fileInput.addEventListener('change', function() {
    const file = fileInput.files[0];
    if (file) {
        imgPreview.src = URL.createObjectURL(file);
        fileName.textContent = file.name;
        fileSize.textContent = `${(file.size / 1024).toFixed(1)} KB`;
        uploadedFile.style.display = 'flex';
    }
});

function removeFile() {
    fileInput.value = '';
    uploadedFile.style.display = 'none';
}