<div>
    <!-- Sticky Filter Bar -->
    <div class="sticky top-[89px] z-40 bg-white/80 backdrop-blur-xl border-b border-gray-100 shadow-[0_4px_30px_rgba(0,0,0,0.02)]">
        <div class="max-w-7xl mx-auto px-6 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                <!-- Category Pills -->
                <div class="flex items-center gap-3 overflow-x-auto pb-2 lg:pb-0 no-scrollbar">
                    @foreach(['All', 'Education', 'Health', 'Environment', 'Emergency', 'Food'] as $cat)
                        <button 
                            wire:click="$set('category', '{{ $cat }}')"
                            class="whitespace-nowrap px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all shadow-sm border {{ $category === $cat ? 'bg-[#1a6b4a] text-white border-[#1a6b4a] shadow-[0_10px_20px_rgba(26,107,74,0.2)]' : 'bg-white text-gray-500 hover:text-[#1a6b4a] border-gray-100 hover:border-[#1a6b4a]/30' }}">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>
                <!-- Search and Sort -->
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <div class="relative w-full sm:w-80 group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors text-xl">search</span>
                        <input 
                            wire:model.live.debounce.300ms="search"
                            class="w-full pl-12 pr-6 py-3.5 rounded-2xl border border-gray-100 focus:ring-2 focus:ring-[#1a6b4a]/20 focus:border-[#1a6b4a] outline-none transition-all font-bold text-xs bg-gray-50/50" 
                            placeholder="Find a cause to support..." 
                            type="text"
                        />
                    </div>
                    <div class="relative w-full sm:w-64">
                        <select 
                            wire:model.live="sort"
                            class="w-full pl-6 pr-12 py-3.5 rounded-2xl border border-gray-100 focus:ring-2 focus:ring-[#1a6b4a]/20 focus:border-[#1a6b4a] outline-none appearance-none transition-all font-bold text-xs bg-gray-50/50">
                            <option value="recent">Sort: Most Recent</option>
                            <option value="ending">Sort: Ending Soon</option>
                            <option value="impact">Sort: Impact Rank</option>
                            <option value="progress">Sort: Goal Progress</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">expand_more</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Campaign Grid -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            @forelse($campaigns as $campaign)
                <div class="bg-white rounded-[2.5rem] shadow-sm overflow-hidden flex flex-col group transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 border border-gray-50">
                    <div class="relative h-64 w-full overflow-hidden">
                        @if($campaign->featured_image_url)
                            <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" src="{{ $campaign->featured_image_url }}" alt="{{ $campaign->title }}"/>
                        @else
                            <div class="w-full h-full bg-gray-50 flex items-center justify-center">
                                <span class="material-symbols-outlined text-5xl text-gray-200">photo_library</span>
                            </div>
                        @endif
                        
                        @php
                            $isEndingSoon = $campaign->end_date && $campaign->end_date->diffInDays(now()) < 14;
                            $isGoalReached = $campaign->progress_percentage >= 100;
                        @endphp

                        <div class="absolute top-6 left-6">
                            @if($isGoalReached)
                                <span class="bg-[#1a6b4a] text-white text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-xl shadow-2xl backdrop-blur-md border border-white/10">Goal Reached</span>
                            @elseif($isEndingSoon)
                                <span class="bg-[#f59e0b] text-white text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-xl shadow-2xl backdrop-blur-md border border-white/10">Ending Soon</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-10 flex flex-col flex-grow">
                        <div class="mb-4">
                            <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">{{ $campaign->category ?? 'Impact' }}</span>
                        </div>
                        <h3 class="font-h4 text-2xl text-on-background mb-4 leading-tight group-hover:text-primary transition-colors">
                            <a href="{{ route('campaigns.show', $campaign) }}">{{ $campaign->title }}</a>
                        </h3>
                        <p class="font-body-sm text-on-surface-variant line-clamp-2 mb-10 leading-relaxed">
                            {{ Str::limit(strip_tags($campaign->description), 120) }}
                        </p>
                        
                        <div class="mt-auto space-y-8">
                            <!-- Progress -->
                            <div>
                                <div class="flex justify-between items-end mb-3">
                                    <span class="font-monetary text-xl text-[#1a6b4a] font-black">{{ $campaign->formatted_raised }}</span>
                                    <span class="font-label-xs text-[10px] text-gray-400 uppercase tracking-widest font-black">{{ $campaign->progress_percentage }}% reached</span>
                                </div>
                                <div class="w-full h-2.5 bg-gray-50 rounded-full overflow-hidden shadow-inner border border-gray-100">
                                    <div class="h-full bg-[#005235] rounded-full transition-all duration-1000" style="width: {{ $campaign->progress_percentage }}%"></div>
                                </div>
                            </div>

                            <!-- Stats Row -->
                            <div class="flex justify-between items-center py-4 border-y border-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-primary/5 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-primary text-xl">event_upcoming</span>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-on-background">
                                            @if($campaign->end_date)
                                                {{ intval(max(0, now()->diffInDays($campaign->end_date))) }}
                                            @else
                                                &infin;
                                            @endif
                                        </p>
                                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Days Left</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 text-right">
                                    <div class="text-right">
                                        <p class="text-xs font-black text-on-background">{{ number_format($campaign->confirmed_donations_count) }}</p>
                                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Donors</p>
                                    </div>
                                    <div class="w-10 h-10 rounded-xl bg-primary/5 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-primary text-xl">group</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-4">
                                <a href="{{ route('campaigns.show', $campaign) }}" class="flex-1 text-center py-5 bg-[#141b2b] text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-md hover:bg-primary transition-all active:scale-95">Support</a>
                                <button class="w-16 h-16 rounded-2xl border-2 border-gray-100 flex items-center justify-center text-gray-400 hover:border-primary hover:text-primary transition-all group/share">
                                    <span class="material-symbols-outlined group-hover:rotate-12 transition-transform">share</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-40 text-center">
                    <div class="w-32 h-32 bg-gray-50 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 shadow-inner">
                        <span class="material-symbols-outlined text-gray-200 text-6xl">search_off</span>
                    </div>
                    <h2 class="font-h2 text-3xl text-gray-900 mb-4 tracking-tight italic">No Campaigns Found</h2>
                    <p class="font-body-base text-gray-500 max-w-md mx-auto leading-relaxed">We couldn't find any campaigns matching your current filters. Try resetting or adjusting your search.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-24">
            {{ $campaigns->links() }}
        </div>
    </section>
</div>


