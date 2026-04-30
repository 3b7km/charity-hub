<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0F172A">
    <title>Volunteer Portal | CharityHub</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --brand-navy: #0A192F;
            --brand-emerald: #10B981;
            --brand-gold: #F59E0B;
            --brand-surface: #F8FAFC;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--brand-surface);
            color: #0F172A;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
        
        /* Utilitarian Elegance Components */
        .glass-panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: 0 4px 24px -6px rgba(15, 23, 42, 0.05);
        }
        .btn-primary {
            background-color: var(--brand-navy);
            color: white;
            transition: all 0.2s ease-in-out;
            position: relative;
            overflow: hidden;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -6px rgba(10, 25, 47, 0.4);
        }
        .btn-primary:focus-visible {
            outline: 2px solid var(--brand-gold);
            outline-offset: 2px;
        }
        .stats-card {
            border-left: 4px solid var(--brand-emerald);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 glass-panel px-6 py-4 flex justify-between items-center" aria-label="Main Navigation">
        <div class="flex items-center gap-3">
            <svg class="w-8 h-8 text-[#0A192F]" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
            <span class="font-bold text-xl tracking-tight">CharityHub</span>
        </div>
        <div class="flex gap-4">
            <a href="/" class="text-sm font-medium hover:text-[#10B981] transition-colors py-2 px-3 rounded-md" aria-label="Return to Home">Home</a>
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700 py-2 px-3 focus-visible:outline-red-500 rounded-md">Log Out</button>
                </form>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Header Section -->
        <header class="mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-[#0A192F] tracking-tight mb-4">Volunteer Portal</h1>
            <p class="text-lg text-slate-600 max-w-2xl">Manage your shifts, track your impact, and stay connected. Your dedication transforms lives.</p>
        </header>

        <!-- Dashboard Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Stats Column (Left) -->
            <div class="lg:col-span-1 space-y-6">
                <section class="glass-panel p-6 rounded-2xl stats-card" aria-labelledby="impact-heading">
                    <h2 id="impact-heading" class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-2">Your Impact</h2>
                    <div class="text-4xl font-bold text-[#0A192F] mb-1">
                        {{ $volunteer->total_hours ?? '0.00' }} <span class="text-lg text-slate-400 font-medium">hrs</span>
                    </div>
                    <p class="text-sm text-[#10B981] font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Top 10% of contributors
                    </p>
                </section>

                <section class="glass-panel p-6 rounded-2xl" aria-labelledby="skills-heading">
                    <h2 id="skills-heading" class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4">Your Skills</h2>
                    <div class="flex flex-wrap gap-2">
                        @forelse($volunteer->skills ?? [] as $skill)
                            <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-semibold">{{ $skill }}</span>
                        @empty
                            <span class="text-sm text-slate-500 italic">No skills added yet.</span>
                        @endforelse
                    </div>
                    <button class="mt-4 text-sm text-[#0A192F] font-semibold hover:underline focus-visible:outline-offset-2" aria-label="Update your profile skills">Update Profile &rarr;</button>
                </section>
            </div>

            <!-- Upcoming Shifts (Right) -->
            <div class="lg:col-span-2">
                <section class="glass-panel p-8 rounded-2xl h-full" aria-labelledby="schedule-heading">
                    <div class="flex justify-between items-end mb-6 border-b border-slate-100 pb-4">
                        <h2 id="schedule-heading" class="text-2xl font-bold text-[#0A192F]">Upcoming Shifts</h2>
                        <a href="#calendar" class="btn-primary px-5 py-2.5 rounded-lg font-semibold text-sm shadow-sm" aria-label="Book a new volunteer shift">Book Shift</a>
                    </div>
                    
                    @if(isset($upcomingShifts) && $upcomingShifts->count() > 0)
                        <ul class="space-y-4" role="list">
                            @foreach($upcomingShifts as $shift)
                                <li class="group flex items-center justify-between p-4 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-200 transition-colors">
                                    <div class="flex items-start gap-4">
                                        <div class="bg-[#0A192F] text-white rounded-lg p-3 text-center min-w-[4rem]">
                                            <span class="block text-xs uppercase font-bold tracking-wider opacity-80">{{ $shift->shift_start->format('M') }}</span>
                                            <span class="block text-xl font-bold">{{ $shift->shift_start->format('d') }}</span>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-[#0A192F]">{{ $shift->campaign->title ?? 'General Volunteering' }}</h3>
                                            <p class="text-sm text-slate-500 mt-1">
                                                <time datetime="{{ $shift->shift_start->toIso8601String() }}">{{ $shift->shift_start->format('H:i') }}</time> - 
                                                <time datetime="{{ $shift->shift_end->toIso8601String() }}">{{ $shift->shift_end->format('H:i') }}</time>
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            {{ ucfirst($shift->status) }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-[#0A192F]">No upcoming shifts</h3>
                            <p class="text-slate-500 mt-2">You don't have any shifts scheduled. Book one today!</p>
                        </div>
                    @endif
                </section>
            </div>
            
        </div>
    </main>

</body>
</html>
