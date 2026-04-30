<div wire:poll.10s class="absolute bottom-8 left-1/2 -translate-x-1/2 w-full max-w-xs z-20 pointer-events-none">
    @if($donations->count() > 0)
        @php $latest = $donations->first(); @endphp
        <div class="bg-white/95 backdrop-blur-md shadow-2xl rounded-2xl p-4 flex items-center gap-4 border border-white animate-bounce-subtle pointer-events-auto">
            <div class="w-12 h-12 rounded-full bg-[#005235] flex items-center justify-center flex-shrink-0 shadow-inner">
                <span class="material-symbols-outlined text-white text-xl">volunteer_activism</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm text-[#141b2b] font-bold truncate">
                    {{ $latest->donor->name ?? 'Someone' }} donated {{ $latest->formatted_amount }}
                </p>
                <p class="text-[10px] text-gray-500 font-medium truncate uppercase tracking-wider">
                    to {{ $latest->campaign->title ?? 'a campaign' }} — {{ $latest->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
    @endif
</div>

<style>
@keyframes bounce-subtle {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
.animate-bounce-subtle {
    animation: bounce-subtle 3s infinite ease-in-out;
}
</style>


