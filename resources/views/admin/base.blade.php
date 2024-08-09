<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Chubcay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link href="toastr.css" rel="stylesheet"/> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">



    <!-- Add your additional CSS and JS links here -->
</head>
<body class="bg-gray-100">
    <div id="app">
        <!-- Navbar -->
        @include('admin.navbar')

        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-4">
                <!-- Sidebar -->
                @include('admin.sidebar')

                <!-- Main Content -->
                <main class="flex-1 px-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- Add your additional scripts here -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script src="{{ asset('javascript/package.js') }}"></script>
    <script src="{{ asset('javascript/sidebar.js') }}"></script>
    <script src="{{ asset('javascript/status.js') }}"></script>
    <script>
        function toggleNavbar() {
            const nav = document.getElementById('navbarNav');
            nav.classList.toggle('hidden');
        }

        function toogleNotificationDropDown () {
            const dropDown = document.getElementById('notification_dropdown');
            if (dropDown.classList.contains('hidden')) {
                dropDown.classList.remove('hidden');
            } else {
                dropDown.classList.add('hidden');
            }
        }

    
    document.addEventListener('DOMContentLoaded', function() {
        const dashboard = document.getElementById('dashboard');
        const membership = document.getElementById('membership');
        
        const user = document.getElementById('manage-users');
        const orders = document.getElementById('manage-orders');

        const logout = document.getElementById('logout');

        if (dashboard) {
            dashboard.addEventListener('click', function() {
                window.location.href = "{{ route('admin.index') }}";
            });
        }
        if(membership) {
            membership.addEventListener('click', function() {
                window.location.href = "{{ route('membership.index') }}";
            });
        }

        if(user) {
            user.addEventListener('click', function (){
                window.location.href = "{{ route('users.index') }}"
            })
        }

        if(orders) {
            orders.addEventListener('click', function() {
                window.location.href = "{{ route('checkout.index') }}"
            })
        }

        if(logout) {
            logout.addEventListener('click', function(){
                window.location.href = "{{ route('logout') }}"
            })
        }

        // users.index
        // else if( user ) {}
        // else if ( orders ) {}
        else {
            console.error('element not found');
        }
    });


    </script>
    
</body>
</html>
