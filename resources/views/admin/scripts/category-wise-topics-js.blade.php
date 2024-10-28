@push('scripts')
<script type="text/javascript">
    let shouldSetOldTopicId = true; // Flag to control setting the old Topic ID
    $(document).ready(function() {
        // Check if a product type is selected on page load
        const initialCategoryId = $('#category_id').val();
        if (initialCategoryId) {
            fetchTopics(initialCategoryId); // Fetch categories for the selected product type
        } else {
            fetchTopics("{{$selectedCategoryId}}");
        }
    });

    $(document).on('change', '#category_id', function(e) {
        const categoryId = $(this).val();
        fetchTopics(categoryId); // Fetch categories when product type changes
    });

    // Fetch categories by product type
    function fetchTopics(categoryId) {
        const topicSelect = $('#topic_id');
        topicSelect.empty(); // Clear existing options
        topicSelect.append('<option value="">Select Topic</option>'); // Add the default option
        $.ajax({
            url: "{{ route('admin.topics.filter_by_category', '') }}/" + categoryId, // Construct URL with categoryId
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}' // Include CSRF token for POST requests
            },
            beforeSend: function() {
                if(categoryId<1){
                    return false;
                }
            },
            success: function(response) {
                if(response.data.length > 0){
                    // Populate the categories
                    $.each(response.data, function(index, topic) {
                        topicSelect.append(`<option value="${topic.id}">${topic.name}</option>`);
                    });
                    if(shouldSetOldTopicId){
    
                        // If there's an old topic_id, select it
                        const selectedTopicId = "{{ $selectedTopicId ?? '' }}"; 
                        if (selectedTopicId > 0) {
                            topicSelect.val(selectedTopicId);
                        }
                    }
                    shouldSetOldTopicId = false;
                }else {
                    if(categoryId > 0){
                        // Show an error message
                        Swal.fire({
                            title: 'Warning!',
                            text: 'No topics found for this category',
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
                    text: 'No topics found for this category',
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