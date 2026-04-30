<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CharityHub — Make a Difference')</title>

    {{-- SEO Meta --}}
    <meta name="description" content="@yield('meta_description', 'CharityHub — A transparent platform for fundraising campaigns, donations, and volunteer coordination.')">
    @hasSection('og_image')
    <meta property="og:image" content="@yield('og_image')">
    @endif
    <meta property="og:title" content="@yield('title', 'CharityHub')">
    <meta property="og:description" content="@yield('meta_description', 'Support causes that matter.')">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    {{-- Livewire Styles --}}
    @livewireStyles

    {{-- Tailwind CDN for development/prototype --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "on-tertiary-fixed-variant": "#653e00",
                      "primary-container": "#1a6b4a",
                      "on-primary-fixed": "#002113",
                      "on-tertiary-fixed": "#2a1700",
                      "primary-fixed-dim": "#8ad6ae",
                      "surface-container": "#e9edff",
                      "tertiary-fixed": "#ffddb8",
                      "surface-tint": "#1a6b4a",
                      "on-secondary-fixed-variant": "#3d4944",
                      "background": "#f9f9ff",
                      "secondary-fixed-dim": "#bdc9c3",
                      "secondary-container": "#d6e3dc",
                      "outline-variant": "#bfc9c0",
                      "on-secondary-fixed": "#131e1a",
                      "secondary-fixed": "#d9e5df",
                      "error-container": "#ffdad6",
                      "tertiary": "#653e00",
                      "outline": "#6f7a72",
                      "on-primary-container": "#9be9bf",
                      "inverse-primary": "#8ad6ae",
                      "on-primary-fixed-variant": "#005235",
                      "tertiary-container": "#855300",
                      "primary-fixed": "#a5f3c9",
                      "primary": "#005235",
                      "surface-container-highest": "#dce2f7",
                      "on-primary": "#ffffff",
                      "on-surface-variant": "#3f4943",
                      "surface-container-low": "#f1f3ff",
                      "on-tertiary": "#ffffff",
                      "surface-variant": "#dce2f7",
                      "on-error-container": "#93000a",
                      "on-background": "#141b2b",
                      "inverse-surface": "#293040",
                      "tertiary-fixed-dim": "#ffb95f",
                      "on-secondary-container": "#596560",
                      "surface-bright": "#f9f9ff",
                      "inverse-on-surface": "#edf0ff",
                      "surface": "#f9f9ff",
                      "on-surface": "#141b2b",
                      "on-tertiary-container": "#ffd099",
                      "secondary": "#55615c",
                      "error": "#ba1a1a",
                      "surface-container-lowest": "#ffffff",
                      "surface-container-high": "#e1e8fd",
                      "on-secondary": "#ffffff",
                      "on-error": "#ffffff",
                      "surface-dim": "#d3daef"
              },
              "borderRadius": {
                      "DEFAULT": "0.25rem",
                      "lg": "0.5rem",
                      "xl": "0.75rem",
                      "full": "9999px"
              },
              "spacing": {
                      "gutter": "1.5rem",
                      "2xl": "3rem",
                      "sm": "0.5rem",
                      "md": "1rem",
                      "xl": "2rem",
                      "xs": "0.25rem",
                      "base": "4px",
                      "container-max": "1280px",
                      "lg": "1.5rem"
              },
                "fontFamily": {
                    "sans": ["Public Sans", "ui-sans-serif", "system-ui"],
                },
            },
          },
        }
    </script>
    <style type="text/tailwindcss">
        @layer base {
            html { font-family: "Public Sans", sans-serif; }
        }
        @layer utilities {
            .font-h1 { @apply font-black tracking-tighter italic; }
            .font-h2 { @apply font-black tracking-tight italic; }
            .font-h3 { @apply font-black tracking-tight; }
            .font-h4 { @apply font-bold tracking-tight; }
            .font-body-base { @apply font-medium leading-relaxed; }
            .font-body-sm { @apply font-medium text-sm leading-relaxed; }
            .font-label-md { @apply font-black text-xs uppercase tracking-[0.2em]; }
            .font-label-xs { @apply font-black text-[10px] uppercase tracking-[0.2em]; }
            .font-monetary { @apply font-black tracking-tighter; }
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
    </style>

    {{-- Alpine.js for interactions --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="bg-surface font-sans text-on-surface selection:bg-primary-container selection:text-on-primary-container antialiased">
    <!-- TopNavBar -->
    <header class="bg-white/90 backdrop-blur-xl sticky top-0 z-50 border-b border-gray-100 shadow-[0_4px_30px_rgba(0,0,0,0.03)]">
        <div class="flex justify-between items-center px-6 py-5 max-w-7xl mx-auto w-full">
            <a href="{{ route('home') }}" class="text-2xl font-black tracking-tighter text-[#1a6b4a] flex items-center gap-2 group">
                <div class="w-8 h-8 rounded-lg bg-[#a5f3c9] flex items-center justify-center group-hover:rotate-12 transition-transform">
                    <span class="material-symbols-outlined text-[#005235] text-xl">volunteer_activism</span>
                </div>
                CharityHub
            </a>
            
            <div class="hidden lg:flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-full border border-gray-100">
                <span class="material-symbols-outlined text-sm text-primary">schedule</span>
                <span id="digital-clock" class="text-[10px] font-black uppercase tracking-widest text-on-surface-variant tabular-nums">00:00:00 AM</span>
            </div>

            <nav class="hidden md:flex items-center gap-10">
                <a class="text-sm font-bold uppercase tracking-widest {{ request()->routeIs('campaigns.index') ? 'text-[#1a6b4a]' : 'text-gray-500 hover:text-[#1a6b4a]' }} transition-colors" href="{{ route('campaigns.index') }}">Campaigns</a>
                <a class="text-sm font-bold uppercase tracking-widest {{ request()->routeIs('impact') ? 'text-[#1a6b4a]' : 'text-gray-500 hover:text-[#1a6b4a]' }} transition-colors" href="{{ route('impact') }}">Impact</a>
                <a class="text-sm font-bold uppercase tracking-widest {{ request()->routeIs('about') ? 'text-[#1a6b4a]' : 'text-gray-500 hover:text-[#1a6b4a]' }} transition-colors" href="{{ route('about') }}">About Us</a>
                <a class="text-sm font-bold uppercase tracking-widest {{ request()->routeIs('transparency') ? 'text-[#1a6b4a]' : 'text-gray-500 hover:text-[#1a6b4a]' }} transition-colors" href="{{ route('transparency') }}">Transparency</a>
            </nav>

            <div class="flex items-center gap-6">
                @auth
                    <!-- User Dropdown Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-4 focus:outline-none group">
                            <div class="text-right hidden sm:block">
                                <p class="text-[10px] font-black uppercase tracking-widest text-primary leading-none mb-1">Account</p>
                                <p class="text-xs font-bold text-on-surface tracking-tight group-hover:text-primary transition-colors">{{ Auth::user()->name }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-on-surface-variant border border-gray-100 group-hover:border-primary/30 transition-all shadow-sm">
                                <span class="material-symbols-outlined text-xl">account_circle</span>
                            </div>
                            <span class="material-symbols-outlined text-sm text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''">expand_more</span>
                        </button>

                        <!-- Dropdown Panel -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-3 w-56 origin-top-right bg-white rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-gray-100 overflow-hidden z-[100]"
                             style="display: none;">
                            
                            <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-50">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-primary mb-1">Active Account</p>
                                <p class="text-xs font-bold text-on-surface truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <div class="p-2">
                                @if(Auth::user()->hasAnyRole(['admin', 'charity_manager']))
                                    <a href="/admin" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-on-surface-variant hover:bg-gray-50 hover:text-primary rounded-xl transition-all">
                                        <span class="material-symbols-outlined text-lg">dashboard</span>
                                        Admin Dashboard
                                    </a>
                                @endif
                                
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-on-surface-variant hover:bg-gray-50 hover:text-primary rounded-xl transition-all">
                                    <span class="material-symbols-outlined text-lg">person</span>
                                    My Account
                                </a>

                                <div class="my-2 border-t border-gray-50"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                        <span class="material-symbols-outlined text-lg">logout</span>
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="/login" class="hidden sm:block font-bold text-xs uppercase tracking-widest text-on-surface-variant hover:text-primary transition-all">Login</a>
                @endauth
                <a href="{{ route('campaigns.index') }}" class="bg-[#1a6b4a] text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest shadow-[0_10px_20px_rgba(26,107,74,0.2)] hover:shadow-xl active:scale-95 transition-all">Donate</a>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-[#141b2b] text-white py-24 px-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary rounded-full blur-[150px] opacity-10"></div>
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-16 relative z-10">
            <div class="md:col-span-1">
                <a href="{{ route('home') }}" class="text-2xl font-black tracking-tighter text-white mb-6 block">CharityHub</a>
                <p class="text-gray-400 text-sm leading-relaxed mb-8">Radical transparency in global giving. Join us in transforming how impact is measured and delivered.</p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-gray-400 hover:bg-white/10 hover:text-white transition-all">
                        <span class="material-symbols-outlined text-lg">public</span>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-gray-400 hover:bg-white/10 hover:text-white transition-all">
                        <span class="material-symbols-outlined text-lg">mail</span>
                    </a>
                </div>
            </div>
            
            <div>
                <h4 class="font-bold uppercase tracking-widest text-xs text-[#9be9bf] mb-8">Platform</h4>
                <ul class="space-y-4 text-sm text-gray-400">
                    <li><a href="{{ route('campaigns.index') }}" class="hover:text-white transition-colors">Active Campaigns</a></li>
                    <li><a href="{{ route('impact') }}" class="hover:text-white transition-colors">Our Impact</a></li>
                    <li><a href="{{ route('transparency') }}" class="hover:text-white transition-colors">Transparency Ledger</a></li>
                    <li><a href="{{ route('volunteer.dashboard') }}" class="hover:text-white transition-colors">Volunteer Center</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold uppercase tracking-widest text-xs text-[#9be9bf] mb-8">Trust & Safety</h4>
                <ul class="space-y-4 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Financial Reports</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Verification Process</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold uppercase tracking-widest text-xs text-[#9be9bf] mb-8">Stay Connected</h4>
                <p class="text-sm text-gray-400 mb-6 leading-relaxed">Get monthly impact updates delivered straight to your inbox.</p>
                <form class="flex gap-2">
                    <input type="email" placeholder="Email" class="bg-white/5 border-white/10 rounded-xl px-4 py-2 text-sm focus:ring-primary focus:border-primary flex-1">
                    <button class="bg-[#1a6b4a] px-4 py-2 rounded-xl text-xs font-bold uppercase">Join</button>
                </form>
            </div>
        </div>
        
        <div class="max-w-7xl mx-auto mt-24 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-xs text-gray-500">© {{ date('Y') }} CharityHub. Registered Charity #123456789. All donations are tax-deductible.</p>
            <div class="flex gap-6 text-[10px] uppercase tracking-widest font-bold text-gray-500">
                <span>London, UK</span>
                <span>San Francisco, CA</span>
            </div>
        </div>
    </footer>


    {{-- Livewire Scripts --}}
    @livewireScripts

    <script>
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { 
                hour12: true, 
                hour: '2-digit', 
                minute: '2-digit'
            });
            const clockElement = document.getElementById('digital-clock');
            if (clockElement) {
                clockElement.textContent = timeString;
            }
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
    @stack('scripts')
</body>
</html>
