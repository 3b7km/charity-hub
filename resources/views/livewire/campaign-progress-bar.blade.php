<div wire:poll.10s>
    <div class="flex justify-between items-end mb-6">
        <div>
            <div class="font-label-xs text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant mb-1">Fundraising Status</div>
            <div class="font-monetary text-4xl text-on-background tracking-tighter">{{ $raised }}</div>
        </div>
        <div class="text-right">
            <div class="font-label-xs text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant mb-1">Target Goal</div>
            <div class="font-monetary text-xl text-on-background/70 tracking-tight">{{ $goal }}</div>
        </div>
    </div>
    
    <!-- Progress Bar -->
    <div class="relative h-5 bg-gray-100 rounded-full overflow-hidden shadow-inner border border-gray-50">
        <div class="absolute inset-y-0 left-0 bg-[#005235] rounded-full transition-all duration-1000 ease-out shadow-[0_0_25px_rgba(0,82,53,0.3)]" style="width: {{ min(100, $percentage) }}%">
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-shimmer"></div>
        </div>
    </div>
    
    <div class="flex justify-between items-center mt-5">
        <div class="flex items-center gap-2">
            <div class="flex items-center justify-center w-6 h-6 rounded-full bg-[#a5f3c9] text-[#005235]">
                <span class="material-symbols-outlined text-[14px] font-black">trending_up</span>
            </div>
            <span class="font-label-md text-sm font-black text-[#1a6b4a] uppercase tracking-widest">{{ $percentage }}% Reached</span>
        </div>
        <div class="font-label-xs text-[10px] font-bold text-on-surface-variant uppercase tracking-widest flex items-center gap-1.5">
            <span class="material-symbols-outlined text-sm">verified_user</span>
            Ledger Verified
        </div>
    </div>
</div>


