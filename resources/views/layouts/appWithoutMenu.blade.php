<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>{{ $setting->shortname_app ?? ' - ' }}</title>
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.css')

</head>

<body>
    <div class="layout-wrapper layout-content-navbar layout-without-menu">
        <div class="layout-container">
            <div class="layout-page">

                @include('layouts.navbar')

                <div class="content-wrapper">

                    <div class="container-xxl container-p-y">

                        @yield('content')

                        @yield('modal')

                    </div>

                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-center py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                Copyright ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                {{ $setting->shortname_app ?? ' - ' }} created by AHHA Developer. All rights reserved.
                            </div>
                            <div class="version mb-2 mb-md-0">
                                Versi {{ $setting->version_app ?? ' - ' }}
                            </div>
                        </div>
                    </footer>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    @include('layouts.js')

</body>

</html>
