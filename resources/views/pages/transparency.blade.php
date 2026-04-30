@extends('layouts.app')

@section('title', 'Radical Transparency — CharityHub')

@section('content')
<!-- Hero Section -->
<section class="bg-[#005235] py-32 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#8ad6ae] rounded-full blur-[100px] translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#8ad6ae] rounded-full blur-[100px] -translate-x-1/2 translate-y-1/2"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        <span class="inline-block px-4 py-1.5 mb-8 rounded-full bg-[#9be9bf]/20 text-[#9be9bf] font-bold text-xs uppercase tracking-widest">Public Ledger</span>
        <h1 class="text-5xl md:text-7xl font-black mb-8 tracking-tighter italic leading-tight">Follow Your Pound.</h1>
        <p class="text-xl text-[#a5f3c9] max-w-2xl mx-auto opacity-90 leading-relaxed">
            We believe that if you give, you deserve to know exactly how your money is used. No smoke, no mirrors.
        </p>
    </div>
</section>

<section class="py-32 max-w-7xl mx-auto px-6 bg-background">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
        <div>
            <h2 class="font-h2 text-h2 text-on-background mb-8 tracking-tight">Real-time Financial Verification</h2>
            <p class="font-body-base text-body-base text-on-surface-variant leading-relaxed mb-10">
                Every donation is recorded on our immutable ledger. When funds are released to a campaign partner, the transaction hash is updated in real-time, allowing anyone to verify the movement of capital.
            </p>
            <div class="space-y-6">
                <div class="flex items-start gap-6 p-6 bg-white rounded-2xl border border-gray-100 shadow-sm transition-transform hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-2xl bg-[#a5f3c9] flex items-center justify-center text-[#005235] flex-shrink-0">
                        <span class="material-symbols-outlined text-2xl">account_balance</span>
                    </div>
                    <div>
                        <h4 class="font-h4 text-xl text-on-background mb-1">Audited Statements</h4>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Monthly financial audits performed by independent third-party agencies to ensure 100% compliance.</p>
                    </div>
                </div>
                <div class="flex items-start gap-6 p-6 bg-white rounded-2xl border border-gray-100 shadow-sm transition-transform hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-2xl bg-[#a5f3c9] flex items-center justify-center text-[#005235] flex-shrink-0">
                        <span class="material-symbols-outlined text-2xl">analytics</span>
                    </div>
                    <div>
                        <h4 class="font-h4 text-xl text-on-background mb-1">0% Admin Fee Policy</h4>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Operational costs are covered by corporate sponsors and donors who choose to "tip", not your primary donation.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Premium Ledger Card -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl p-10 border border-gray-100 relative overflow-hidden">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-[#a5f3c9] rounded-full blur-[80px] opacity-20"></div>
            <div class="flex justify-between items-center mb-10">
                <h3 class="font-h3 text-2xl text-on-background tracking-tight">Recent Ledger Entries</h3>
                <span class="px-3 py-1 bg-[#1a6b4a]/10 text-[#1a6b4a] font-bold text-[10px] rounded-full uppercase tracking-widest animate-pulse">Live Sync</span>
            </div>
            
            <div class="space-y-8">
                @forelse($ledgerEntries as $entry)
                    <div class="flex justify-between items-center pb-6 border-b border-gray-50 last:border-0 last:pb-0 group">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-2 rounded-full {{ $entry->type === 'debit' ? 'bg-[#f59e0b]' : 'bg-[#1a6b4a]' }}"></div>
                            <div>
                                <div class="font-label-xs text-[10px] uppercase tracking-[0.15em] text-[#1a6b4a] mb-1 font-bold">{{ strtoupper($entry->type) }}</div>
                                <div class="font-label-md text-on-background group-hover:text-primary transition-colors">
                                    {{ $entry->donation?->campaign?->title ?? 'General Fund' }}
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-monetary text-lg text-on-background">{{ $entry->formatted_amount }}</div>
                            <div class="font-label-xs text-[10px] text-on-surface-variant font-mono">{{ substr($entry->id, 0, 8) }}...</div>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center text-on-surface-variant font-bold italic">
                        No ledger entries recorded yet.
                    </div>
                @endforelse
            </div>
            
            <div class="mt-12 flex flex-col gap-4">
                <a href="{{ route('ledger.download') }}" class="w-full py-4 bg-[#141b2b] text-white rounded-xl font-bold text-sm hover:shadow-xl transition-all active:scale-95 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-lg">download</span>
                    Download Full Ledger (CSV)
                </a>
                <p class="text-center text-[10px] text-on-surface-variant uppercase tracking-widest font-bold">Last backup: {{ now()->format('H:i T') }}</p>
            </div>
        </div>
    </div>
</section>

@endsection
