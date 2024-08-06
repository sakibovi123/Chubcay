<nav class="bg-slate-800 border-b border-gray-200 p-5">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <a class="text-lg font-bold text-white" href="#">CHUBCAY ADMIN</a>
        {{-- <button class="block lg:hidden text-gray-800 focus:outline-none" type="button" onclick="document.getElementById('navbarNav').classList.toggle('hidden')">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button> --}}
        {{-- <button class="block lg:hidden text-gray-800 focus:outline-none" type="button" onclick="toggleNavbar()"> --}}

        <div class="hidden lg:flex lg:items-center w-full lg:w-auto" id="navbarNav">
            <ul class="flex flex-col lg:flex-row lg:space-x-4 mt-4 lg:mt-0">
                <li>
                    {{-- <a onclick="toogleNotificationDropDown()" class="text-gray-800 hover:text-blue-600" href="#">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.133 12.632v-1.8a5.406 5.406 0 0 0-4.154-5.262.955.955 0 0 0 .021-.106V3.1a1 1 0 0 0-2 0v2.364a.955.955 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C6.867 15.018 5 15.614 5 16.807 5 17.4 5 18 5.538 18h12.924C19 18 19 17.4 19 16.807c0-1.193-1.867-1.789-1.867-4.175ZM8.823 19a3.453 3.453 0 0 0 6.354 0H8.823Z"/>
                        </svg>
                    </a> --}}

                    <div id="notification_dropdown" class="w-full fixed top-[70px] right-[-1370px] hidden">
                        <ul class="w-[18%] p-2 bg-white border rounded">
                            <li class="transition-all delay-5 hover:bg-gray-200 p-5 border-b-2 border-gray-400 flex items-center justify-between gap-3">
                                <svg class="w-7 h-7 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z"/>
                                </svg>
                                <a href="">
                                    <p class="text-lg font-bold">Notification Title</p>
                                    <small class="text-sm text-gray-500">Lorem ipsum dolor lorem ipsum</small>
                                </a>
                            </li>
                            <li class="transition-all delay-5 hover:bg-gray-200 p-5 border-b-2 border-gray-400 flex items-center justify-between gap-3">
                                <svg class="w-7 h-7 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z"/>
                                </svg>
                                <a href="">
                                    <p class="text-lg font-bold">Notification Title</p>
                                    <small class="text-sm text-gray-500">Lorem ipsum dolor lorem ipsum</small>
                                </a>
                            </li>
                            <li class="transition-all delay-5 hover:bg-gray-200 p-5 border-b-2 border-gray-400 flex items-center justify-between gap-3">
                                <svg class="w-7 h-7 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z"/>
                                </svg>
                                <a href="">
                                    <p class="text-lg font-bold">Notification Title</p>
                                    <small class="text-sm text-gray-500">Lorem ipsum dolor lorem ipsum</small>
                                </a>
                            </li>
                            <li class="transition-all delay-5 hover:bg-gray-200 p-5 border-b-2 border-gray-400 flex items-center justify-between gap-3">
                                <svg class="w-7 h-7 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5.365V3m0 2.365a5.338 5.338 0 0 1 5.133 5.368v1.8c0 2.386 1.867 2.982 1.867 4.175 0 .593 0 1.292-.538 1.292H5.538C5 18 5 17.301 5 16.708c0-1.193 1.867-1.789 1.867-4.175v-1.8A5.338 5.338 0 0 1 12 5.365ZM8.733 18c.094.852.306 1.54.944 2.112a3.48 3.48 0 0 0 4.646 0c.638-.572 1.236-1.26 1.33-2.112h-6.92Z"/>
                                </svg>
                                <a href="">
                                    <p class="text-lg font-bold">Notification Title</p>
                                    <small class="text-sm text-gray-500">Lorem ipsum dolor lorem ipsum</small>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a class="text-gray-800 hover:text-blue-600" href="{{ route('logout') }}">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
                        </svg>
                        
                    </a>
                </li>
                {{-- <li>
                    <a class="text-gray-800 hover:text-blue-600" href="#">Pricing</a>
                </li> --}}
            </ul>
        </div>
    </div>
</nav>
