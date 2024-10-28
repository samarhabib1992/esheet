@push('scripts')
<script type="text/javascript">
    let shouldSetOldCategoryId = true; // Flag to control setting the old category ID
    $(document).ready(function() {
        // Check if a product type is selected on page load
        const initialProductTypeId = $('#product_type_id').val();
        if (initialProductTypeId) {
            fetchCategories(initialProductTypeId); // Fetch categories for the selected product type
        } else {
            fetchCategories("{{$selectedProductTypeId}}");
        }
    });

    $(document).on('change', '#product_type_id', function(e) {
        const productTypeId = $(this).val();
        fetchCategories(productTypeId); // Fetch categories when product type changes
    });

    // Fetch categories by product type
    function fetchCategories(productTypeId) {
        const categorySelect = $('#category_id');
        categorySelect.empty(); // Clear existing options
        categorySelect.append('<option value="">Select Category</option>'); // Add the default option
        $.ajax({
            url: "{{ route('admin.categories.filter_by_product_type', '') }}/" + productTypeId, // Construct URL with productTypeId
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}' // Include CSRF token for POST requests
            },
            beforeSend: function() {
                if(productTypeId<1){
                    return false;
                }
            },
            success: function(response) {
                if(response.data.length>0){
                    // Populate the categories
                    $.each(response.data, function(index, category) {
                        categorySelect.append(`<option value="${category.id}">${category.name}</option>`);
                    });
                    if(shouldSetOldCategoryId){

                        // If there's an old category_id, select it
                        const selectedCategoryId = "{{ $selectedCategoryId ?? '' }}"; // Get selected category ID from props
                        if (selectedCategoryId > 0) {
                            categorySelect.val(selectedCategoryId);
                        }
                    }
                    shouldSetOldCategoryId = false;
                } else{
                    if(productTypeId > 0){
                        // Show an error message
                        Swal.fire({
                            title: 'Warning!',
                            text: 'No category found for this product type',
                            icon: 'warning',
                            confirmButtonText: 'OK',
                            timer: 2000,
                            timerProgressBar: true,
                        });
                    }
                }
            },
            error: function(xhr) {
                console.error(xhr);
                Swal.fire({
                    title: 'Warning!',
                    text: 'No category found for this product type',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    timer: 2000,
                    timerProgressBar: true,
                });
            }
        });
    }
</script>
@endpush