<div class="max-w-7xl mx-auto px-6 py-12">
    @if(session()->has('message'))
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl font-bold text-sm flex items-center gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('message') }}
        </div>
    @endif

    @if(!$volunteer)
        <div class="bg-white rounded-[2.5rem] shadow-xl p-20 text-center border border-gray-50 relative overflow-hidden">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-[#a5f3c9] rounded-full blur-[80px] opacity-20"></div>
            <div class="w-24 h-24 bg-[#a5f3c9]/30 rounded-[2rem] flex items-center justify-center mx-auto mb-10">
                <span class="material-symbols-outlined text-[#005235] text-5xl">volunteer_activism</span>
            </div>
            <h2 class="font-h2 text-4xl text-on-background mb-6 tracking-tight italic">Start Your Impact Journey</h2>
            <p class="font-body-base text-on-surface-variant max-w-md mx-auto mb-12 leading-relaxed">
                You haven't registered as a volunteer yet. Join our global community of dedicated change-makers and start making a difference today.
            </p>
            <button 
                wire:click="register"
                class="inline-flex items-center gap-3 bg-[#f59e0b] text-white px-10 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-lg hover:shadow-2xl active:scale-95 transition-all">
                Complete Volunteer Profile
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </button>
        </div>
    @else
        <!-- Dashboard Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Volunteer Dashboard</h1>
                <p class="text-gray-500">Welcome back, {{ Auth::user()->name }}. Here's your impact overview.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-4 py-2 bg-white rounded-lg border border-gray-100 shadow-sm flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full {{ $volunteer->isVerified() ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                    <span class="text-xs font-bold uppercase tracking-widest text-gray-600">
                        {{ $volunteer->isVerified() ? 'Verified Profile' : 'Pending Verification' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 group hover:border-primary/20 transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">schedule</span>
                    </div>
                </div>
                <div class="text-4xl font-black text-gray-900 mb-1">{{ number_format($volunteer->total_hours, 1) }}</div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">Total Hours Contributed</div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 group hover:border-primary/20 transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">event_available</span>
                    </div>
                </div>
                <div class="text-4xl font-black text-gray-900 mb-1">{{ optional($upcomingShifts)->count() ?? 0 }}</div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">Upcoming Shifts</div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 group hover:border-primary/20 transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">verified</span>
                    </div>
                </div>
                <div class="text-4xl font-black text-gray-900 mb-1">{{ $volunteer->isVerified() ? 'Active' : 'Pending' }}</div>
                <div class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">Impact Status</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Schedule Section -->
            <div class="lg:col-span-8 space-y-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-gray-900 tracking-tight">Upcoming Schedule</h2>
                        <button class="text-xs font-bold uppercase tracking-widest text-primary hover:opacity-70 transition-opacity">
                            View Calendar
                        </button>
                    </div>
                    <div class="p-0">
                        @forelse($upcomingShifts ?? [] as $shift)
                            <div class="flex items-center gap-6 px-8 py-6 hover:bg-gray-50 transition-colors border-b last:border-0 border-gray-50">
                                <div class="flex-shrink-0 w-14 h-14 bg-gray-50 rounded-xl flex flex-col items-center justify-center border border-gray-100">
                                    <span class="text-[10px] font-bold uppercase text-gray-400 leading-none mb-1">{{ $shift->shift_start->format('M') }}</span>
                                    <span class="text-xl font-black text-gray-900 leading-none">{{ $shift->shift_start->format('d') }}</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 mb-1">{{ $shift->campaign->title }}</h3>
                                    <div class="flex items-center gap-3 text-xs text-gray-500 font-medium">
                                        <span class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                                            {{ $shift->shift_start->format('H:i') }} — {{ $shift->shift_end->format('H:i') }}
                                        </span>
                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                        <span class="px-2 py-0.5 rounded bg-gray-100 text-[10px] font-bold uppercase">{{ $shift->status }}</span>
                                    </div>
                                </div>
                                <button class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                    <span class="material-symbols-outlined">cancel</span>
                                </button>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <span class="material-symbols-outlined text-gray-200 text-6xl mb-4">event_busy</span>
                                <p class="text-gray-400 font-medium">No upcoming shifts scheduled.</p>
                                <a href="{{ route('campaigns.index') }}" class="text-primary font-bold text-sm mt-2 inline-block">Browse Campaigns to Join</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar / Recent Activity -->
            <div class="lg:col-span-4 space-y-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50">
                        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-widest">Recent Contributions</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            @forelse($recentHours ?? [] as $record)
                                <div class="flex items-center justify-between group">
                                    <div class="flex items-center gap-3">
                                        <div class="w-1.5 h-10 rounded-full bg-emerald-500 opacity-20 group-hover:opacity-100 transition-opacity"></div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900 leading-tight mb-1">{{ $record->hours_logged }} Hours Logged</div>
                                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $record->shift_end->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                                        <span class="material-symbols-outlined text-sm">history</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-400 text-center py-4">No recent activity found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Skills & Expertise Card -->
                <div class="bg-[#005235] rounded-2xl shadow-lg p-8 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <span class="material-symbols-outlined text-6xl">school</span>
                    </div>
                    <h3 class="text-lg font-bold mb-6 tracking-tight">Your Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($volunteer->skills ?? [] as $skill)
                            <span class="px-3 py-1 bg-white/10 rounded-lg text-xs font-bold backdrop-blur-sm border border-white/10 uppercase tracking-tighter">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

