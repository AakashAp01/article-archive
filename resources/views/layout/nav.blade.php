<nav x-data="{ mobileOpen: false, adminOpen: false, userOpen: false }"
    class="fixed top-0 w-full bg-[#0a0a0f]/95 border-b border-white/5 h-14 z-50 backdrop-blur-md font-display">

    <div class="max-w-6xl mx-auto px-4 h-full flex items-center justify-between">

        {{-- LOGO --}}
        <a href="{{ route('welcome') }}" class="flex items-center gap-2 group">
            <span class="text-2xl font-semibold tracking-wide text-white group-hover:opacity-80 transition-opacity">
                AkashAp<span class="text-accent">.dev</span>
            </span>
        </a>

        {{-- DESKTOP NAVIGATION --}}
        <div class="hidden md:flex items-center gap-6">

            @auth
                {{-- ADMIN DROPDOWN --}}
                @if (Auth::user()->type === 'admin')
                    <div class="relative" @click.outside="adminOpen = false">
                        <button @click="adminOpen = !adminOpen"
                            class="flex items-center gap-2 text-xs uppercase tracking-widest text-[#888] hover:text-white transition-colors focus:outline-none">
                            System Menu
                            <svg class="w-3 h-3 transition-transform duration-200" :class="{ 'rotate-180': adminOpen }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        {{-- Admin Menu --}}
                        <div x-show="adminOpen" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-[#0a0a0f] border border-white/10 shadow-2xl py-1 z-50 origin-top-right rounded-sm"
                            style="display: none;">

                            <a href="{{ route('dashboard') }}"
                                class="block px-4 py-2 text-xs text-[#ccc] hover:bg-white/5 hover:text-accent transition-colors">Dashboard</a>
                            <a href="{{ route('article.index') }}"
                                class="block px-4 py-2 text-xs text-[#ccc] hover:bg-white/5 hover:text-accent transition-colors">Articles</a>
                            <a href="{{ route('newsletter.index') }}"
                                class="block px-4 py-2 text-xs text-[#ccc] hover:bg-white/5 hover:text-accent transition-colors">Newsletter</a>
                            <a href="{{ route('categories.index') }}"
                                class="block px-4 py-2 text-xs text-[#ccc] hover:bg-white/5 hover:text-accent transition-colors">Categories</a>
                            <a href="{{ route('users.index') }}"
                                class="block px-4 py-2 text-xs text-[#ccc] hover:bg-white/5 hover:text-accent transition-colors">Users</a>
                            <a href="{{ route('email-templates') }}"
                                class="block px-4 py-2 text-xs text-[#ccc] hover:bg-white/5 hover:text-accent transition-colors">Email
                                Templates</a>
                            <a href="{{ route('settings') }}"
                                class="block px-4 py-2 text-xs text-[#ccc] hover:bg-white/5 hover:text-accent transition-colors">Settings</a>
                        </div>
                    </div>
                @endif

                {{-- USER DROPDOWN (AVATAR VERSION) --}}
                <div class="relative" @click.outside="userOpen = false">
                    <button @click="userOpen = !userOpen"
                        class="flex items-center gap-3 pl-4 focus:outline-none group">

                        {{-- Name (Hidden on very small screens if needed, but keeping for desktop) --}}
                        <div class="text-right hidden lg:block">
                            <div
                                class="text-xs font-bold text-white uppercase tracking-wider group-hover:text-accent transition-colors">
                                {{ Auth::user()->name }}
                            </div>
                        </div>

                        {{-- Avatar --}}
                        <div class="h-8 w-8 rounded-full border border-white/20 overflow-hidden group-hover:border-accent group-hover:shadow-[0_0_10px_rgba(0,255,136,0.2)] transition-all duration-300">
                            <img src="{{  Auth::user()->avatar }}"
                                alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
                        </div>

                        {{-- Down Arrow --}}
                        <svg class="w-3 h-3 text-[#666] group-hover:text-white transition-transform duration-200"
                            :class="{ 'rotate-180': userOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>

                    </button>

                    {{-- User Menu --}}
                    <div x-show="userOpen" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-4 w-48 bg-[#0a0a0f] border border-white/10 shadow-2xl py-1 z-50 origin-top-right rounded-md overflow-hidden"
                        style="display: none;">

                        <a href="{{ route('profile') }}"
                            class="flex items-center gap-2 px-4 py-2 text-xs text-[#ccc] hover:bg-white/5 hover:text-accent transition-colors">
                            <span>Profile</span>
                        </a>
                        
                        <a href="{{ route('articles.saved') }}"
                             class="flex items-center gap-2 px-4 py-2 text-xs text-[#ccc] hover:bg-white/5 hover:text-accent transition-colors">
                            <span>Saved Articles</span>
                        </a>

                        <div class="border-t border-white/5 my-1"></div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-xs text-red-500 hover:bg-red-500/10 hover:text-red-400 tracking-widest transition-colors flex items-center gap-2">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                    class="text-sm font-bold text-accent tracking-widest hover:underline decoration-accent underline-offset-4 transition-all">
                    Login
                </a>
            @endauth

        </div>

        {{-- MOBILE TOGGLE --}}
        <button @click="mobileOpen = !mobileOpen" class="md:hidden text-white focus:outline-none p-2 -mr-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"></path>
                <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" style="display: none;"></path>
            </svg>
        </button>

    </div>

    {{-- MOBILE MENU --}}
    @auth
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden absolute top-14 left-0 w-full bg-[#0a0a0f] border-b border-white/10 shadow-2xl z-40"
            style="display: none;">

            <div class="p-4 space-y-4">

                {{-- User Info with Avatar --}}
                <div class="flex items-center gap-4 border-b border-white/5 pb-4">
                     <div class="h-10 w-10 rounded-full border border-accent/30 overflow-hidden shadow-[0_0_10px_rgba(0,255,136,0.1)]">
                        <img src="{{ Auth::user()->avatar }}"
                            alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
                    </div>
                    <div>
                        <div class="text-sm font-bold text-white uppercase">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-[#666] uppercase tracking-widest">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                @if (Auth::user()->type === 'admin')
                    <div class="mb-4">
                        <div class="text-[10px] text-accent uppercase tracking-widest mb-2 font-bold">System Menu</div>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('dashboard') }}"
                                class="p-2 bg-white/5 border border-white/5 hover:border-accent text-xs text-[#ccc] text-center rounded-sm transition-colors">Dashboard</a>
                            <a href="{{ route('article.index') }}"
                                class="p-2 bg-white/5 border border-white/5 hover:border-accent text-xs text-[#ccc] text-center rounded-sm transition-colors">Articles</a>
                            <a href="{{ route('newsletter.index') }}"
                                class="p-2 bg-white/5 border border-white/5 hover:border-accent text-xs text-[#ccc] text-center rounded-sm transition-colors">Newsletter</a>
                            <a href="{{ route('categories.index') }}"
                                class="p-2 bg-white/5 border border-white/5 hover:border-accent text-xs text-[#ccc] text-center rounded-sm transition-colors">Categories</a>
                            <a href="{{ route('users.index') }}"
                                class="p-2 bg-white/5 border border-white/5 hover:border-accent text-xs text-[#ccc] text-center rounded-sm transition-colors">Users</a>
                            <a href="{{ route('email-templates') }}"
                                class="p-2 bg-white/5 border border-white/5 hover:border-accent text-xs text-[#ccc] text-center rounded-sm transition-colors">Templates</a>
                            <a href="{{ route('settings') }}"
                                class="p-2 bg-white/5 border border-white/5 hover:border-accent text-xs text-[#ccc] text-center rounded-sm transition-colors">Settings</a>
                        </div>
                    </div>
                @endif

                <div class="border-t border-white/5 pt-4">
                    <div class="text-[10px] text-[#666] uppercase tracking-widest mb-2 font-bold">User Actions</div>
                    <div class="grid grid-cols-2 gap-2">
                        {{-- Profile Button --}}
                        <a href="{{ route('profile') }}"
                            class="p-2 bg-white/5 border border-white/5 hover:border-accent text-xs text-[#ccc] hover:text-white text-center rounded-sm transition-colors tracking-wider">
                            Profile
                        </a>

                        {{-- Saved Articles Button --}}
                        <a href="{{ route('articles.saved') }}"
                            class="p-2 bg-white/5 border border-white/5 hover:border-accent text-xs text-[#ccc] hover:text-white text-center rounded-sm transition-colors tracking-wider">
                            Saved Articles
                        </a>
                    </div>
                    
                    {{-- Disconnect Button --}}
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit"
                            class="p-2 bg-white/5 border border-white/5 hover:border-red-500 text-xs text-red-500 hover:text-red-400 text-center rounded-sm transition-colors tracking-wider font-bold w-full">
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </div>
    @endauth

</nav>