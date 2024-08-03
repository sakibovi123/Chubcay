<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Chubcay</title>
    <script src="https://cdn.tailwindcss.com"></script>

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

    //     document.addEventListener('click', function(event) {
    //     const dropDown = document.getElementById('notification_dropdown');
    //     const trigger = event.target.closest('[onclick="toggleNotificationDropDown()"]');
    //     const isClickInside = dropDown.contains(event.target);

    //     if (!isClickInside && !trigger) {
    //         dropDown.classList.add('hidden');
    //     }
    // });

    
    document.addEventListener('DOMContentLoaded', function() {
        const dashboard = document.getElementById('dashboard');
        const membership = document.getElementById('membership');
        
        // const user = document.getElementById('user');
        // const orders = document.getElementById('order');

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
        // else if( user ) {}
        // else if ( orders ) {}
        else {
            console.error('element not found');
        }
    });
    
    </script>
</body>
</html>
