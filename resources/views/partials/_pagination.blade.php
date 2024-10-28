@if($result instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $result->links('vendor.pagination.bootstrap-5') }}
@endif