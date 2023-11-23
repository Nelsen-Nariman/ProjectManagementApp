<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    @auth
        @if (Auth::user()->email_verified_at != null)
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Greetings -->
                    <div class="flex items-center">
                        @php
                            $oriName = Auth::user()->name;
                            $displayName;
                            
                            if (preg_match('/\s/', $oriName)) {
                                $nameParts = explode(" ", $oriName);
                                $displayName = $nameParts[0];
                            } else {
                                $displayName = $oriName;

                                if (strlen($displayName) > 15) {
                                    $displayName = substr($oriName, 0, 16) . "...";
                                }
                            }

                            echo "Hello, " . $displayName . "!";
                        @endphp
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': open, 'hidden': ! open}">
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('projects')" :active="request()->routeIs('projects')">
                        {{ __('List Project') }}
                    </x-responsive-nav-link>

                    @if (Auth::user()->role == "admin")
                        <x-responsive-nav-link :href="route('workers')" :active="request()->routeIs('workers')">
                            {{ __('Manage Worker') }}
                        </x-responsive-nav-link>
                    @endif
                </div>

                <!-- Responsive Settings Options -->
                <div class="pb-1 border-t border-gray-200">
                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-responsive-nav-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>      
        @endif  
    @endauth


    @guest
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="fixed top-0 right-0 px-6 py-4 sm:block">
                <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Log in') }}
                </x-nav-link>

                <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Register') }}
                </x-nav-link>
            </div>
        </div>
    @endguest
</nav>
