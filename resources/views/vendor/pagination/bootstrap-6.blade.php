<!-- Main Container for pagination controls -->
<div class="d-flex flex-row justify-content-start align-items-center mt-5 w-100">

    <!-- Dropdown for Records Per Page -->
    <div class="d-flex flex-row justify-content-start align-items-center flex-grow-1">
        <div class="text-start flex-grow-0">
            @php
            // Define the closure within the Blade template
            $appendQueryParams = function ($url, $params) {
            try {
            // Parse the URL to get components
            $parsedUrl = parse_url($url);

            // Extract existing query parameters if any
            $queryParams = [];
            if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
            }

            // Merge with new parameters
            $queryParams = array_merge($queryParams, $params);

            // Rebuild the query string
            $queryString = http_build_query($queryParams);

            // Rebuild the URL with the new query string
            return (isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '') .
            (isset($parsedUrl['host']) ? $parsedUrl['host'] : '') .
            (isset($parsedUrl['path']) ? $parsedUrl['path'] : '') .
            (!empty($queryString) ? '?' . $queryString : '');

            } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error appending query parameters: ' . $e->getMessage());

            // Return the original URL if an error occurs
            return $url;
            }
            };

            $routeName = Route::currentRouteName();
            $routeName = str_replace('.', '-', $routeName);
            $paginationLimits = config('doobert.pagination.' . $routeName);
            $params = request()->except('page'); // Define $params here
            @endphp
            @if(!empty($paginationLimits))
            <select class="form-select" onchange="window.location.href = this.value">
                @forelse($paginationLimits as $limit)
                @php
                if($paginator->url(1)){
                $url = $paginator->url(1);
                }else{
                $url = $paginator->url($paginator->currentPage());
                }
                $url = $appendQueryParams($url, array_merge($params, ['limit' => $limit])); // Use $params here
                @endphp
                <option value="{{ $url }}" @if(request()->get('limit', $paginator->perPage()) == $limit) selected @endif>{{ $limit }}</option>
                @empty
                @endforelse
            </select>
            @endif
        </div>

        <!-- Showing x to y of z results -->
        <div class="text-start ml-3 flex-grow-0 mx-2">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>
    </div>
    @if ($paginator->hasPages())

    <!-- Pagination Links -->
    <ul class="pagination pagination-circle pagination-outline ml-3 justify-content-center flex-grow-0">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="page-item first disabled m-1">
            <span class="page-link px-0">
                <i class="ki-duotone ki-double-left fs-2"><span class="path1"></span><span class="path2"></span></i>
            </span>
        </li>
        <li class="page-item previous disabled m-1">
            <span class="page-link px-0">
                <i class="ki-duotone ki-left fs-2"></i>
            </span>
        </li>
        @else
        @php
        $firstPageUrl = $appendQueryParams($paginator->url(1), $params); // Use $params here
        $previousPageUrl = $appendQueryParams($paginator->previousPageUrl(), $params); // Use $params here
        @endphp
        <li class="page-item first m-1">
            <a href="{{ $firstPageUrl }}" class="page-link px-0">
                <i class="ki-duotone ki-double-left fs-2"><span class="path1"></span><span class="path2"></span></i>
            </a>
        </li>
        <li class="page-item previous m-1">
            <a href="{{ $previousPageUrl }}" class="page-link px-0">
                <i class="ki-duotone ki-left fs-2"></i>
            </a>
        </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <li class="page-item disabled m-1"><span class="page-link">{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @php
        $url = $appendQueryParams($url, $params); // Use $params here
        @endphp
        @if ($page == $paginator->currentPage())
        <li class="page-item active m-1"><span class="page-link">{{ $page }}</span></li>
        @else
        <li class="page-item m-1"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        @php
        $nextPageUrl = $appendQueryParams($paginator->nextPageUrl(), $params); // Use $params here
        $lastPageUrl = $appendQueryParams($paginator->url($paginator->lastPage()), $params); // Use $params here
        @endphp
        <li class="page-item next m-1">
            <a href="{{ $nextPageUrl }}" class="page-link px-0">
                <i class="ki-duotone ki-right fs-2"></i>
            </a>
        </li>
        <li class="page-item last m-1">
            <a href="{{ $lastPageUrl }}" class="page-link px-0">
                <i class="ki-duotone ki-double-right fs-2"><span class="path1"></span><span class="path2"></span></i>
            </a>
        </li>
        @else
        <li class="page-item next disabled m-1">
            <span class="page-link px-0">
                <i class="ki-duotone ki-right fs-2"></i>
            </span>
        </li>
        <li class="page-item last disabled m-1">
            <span class="page-link px-0">
                <i class="ki-duotone ki-double-right fs-2"><span class="path1"></span><span class="path2"></span></i>
            </span>
        </li>
        @endif
    </ul>
    @endif

    <div class="flex-grow-1"></div>
</div>