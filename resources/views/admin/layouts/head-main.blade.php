<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">

<head>

    <title>@yield('title') </title>
    @include('admin/layouts/title-meta')

    @include('admin/layouts/head-css')

</head>

@include('admin/layouts/body')

<div class="main-wrapper">
    @include('admin/layouts/menu')

    <!-- Layout Content -->
    @yield('content')


@include('admin/layouts/vendor-scripts')

</body>

</html>
