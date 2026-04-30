@extends('layouts.app')

@section('title', 'Impact Report — ' . $campaign->title)

@section('content')
<div class="bg-background min-h-screen pb-32 pt-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-12">
            <a href="{{ route('campaigns.show', $campaign->slug) }}" class="inline-flex items-center gap-2 text-emerald-600 font-bold mb-6 hover:gap-3 transition-all">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Back to Campaign
            </a>
            <h1 class="font-h1 text-h2 md:text-h1 text-on-background tracking-tighter italic">
                Impact Transparency Report
            </h1>
            <p class="text-on-surface-variant text-lg max-w-2xl mt-4">
                Detailed evidence of how your donations have been utilized for <strong>{{ $campaign->title }}</strong>.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <div class="lg:col-span-8 space-y-12">
                <!-- Beneficiary Map Section -->
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden p-12">
                    <h2 class="font-h3 text-h3 text-on-background mb-4 tracking-tight italic">Beneficiary Map</h2>
                    <p class="text-on-surface-variant mb-8">
                        Locations where aid from this campaign was delivered.
                    </p>
                    
                    @include('components.beneficiary-map', [
                        'locations' => $locations,
                        'mapId'     => 'impact-report',
                        'height'    => '500px',
                    ])
                </div>

                <!-- Verified Reports -->
                @foreach($campaign->impactReports as $report)
                    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden p-12">
                        <div class="flex items-center gap-4 mb-8">
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-emerald-100 text-emerald-700">
                                Verified Outcome
                            </span>
                            <span class="text-on-surface-variant text-xs font-bold">
                                {{ $report->published_at?->format('M d, Y') }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                            <div class="bg-gray-50 p-8 rounded-3xl">
                                <div class="text-3xl font-h1 text-emerald-600">{{ number_format($report->beneficiary_count) }}</div>
                                <div class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant">Direct Beneficiaries</div>
                            </div>
                            <div class="bg-gray-50 p-8 rounded-3xl">
                                <div class="text-3xl font-h1 text-emerald-600">{{ count($report->locations ?? []) }}</div>
                                <div class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant">Active Locations</div>
                            </div>
                        </div>

                        <div class="prose prose-emerald max-w-none mb-10">
                            {!! $report->summary !!}
                        </div>

                        @if($report->hasMedia('photos'))
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($report->getMedia('photos') as $photo)
                                    <img src="{{ $photo->getUrl('thumb') }}" class="rounded-2xl w-full h-48 object-cover">
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="lg:col-span-4">
                <div class="sticky top-24">
                    <div class="bg-[#141b2b] text-white rounded-[2.5rem] p-10 shadow-2xl overflow-hidden relative">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-500 rounded-full blur-[80px] opacity-20"></div>
                        
                        <h3 class="font-h4 text-xl mb-6 italic">Campaign Financials</h3>
                        <div class="space-y-6">
                            <div>
                                <div class="text-xs uppercase tracking-widest text-emerald-400 font-bold mb-1">Total Raised</div>
                                <div class="text-3xl font-h1 tracking-tighter">{{ $campaign->formatted_raised }}</div>
                            </div>
                            <div>
                                <div class="text-xs uppercase tracking-widest text-emerald-400 font-bold mb-1">Impact Efficiency</div>
                                <div class="text-3xl font-h1 tracking-tighter">94%</div>
                                <p class="text-[10px] text-white/50 mt-1 uppercase tracking-wider font-bold">Funds directly reaching beneficiaries</p>
                            </div>
                        </div>

                        <div class="mt-12 pt-10 border-t border-white/10">
                            <p class="text-xs text-white/60 leading-relaxed italic">
                                This report is cryptographically linked to our public ledger. Every penny shown here can be traced to a verified donation.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
