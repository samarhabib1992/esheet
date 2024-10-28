<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials._favicon')
    <title>@yield('title', 'E-Sheet')</title>
    <!-- Include styles -->
    @include('front.layouts.partials._styles')
</head>
<body>
    <!-- Header -->
    @include('front.layouts.partials._header')
    <!-- End of Header -->
    @yield('content')
    <!-- Footer -->
    @include('front.layouts.partials._footer')
    <!-- End of Footer -->
    @include('front.layouts.partials._scripts')
</body>

</html>
