@extends('layouts.app')

@section('title', $meta['title'])
@section('meta_description', $meta['description'])
@section('og_image', $meta['image'])

@section('content')
<div class="bg-background min-h-screen pb-32">
    <!-- Campaign Header/Hero -->
    <div class="relative h-[500px] md:h-[650px] bg-[#005235] overflow-hidden">
        @if($campaign->featured_image_url)
            <img src="{{ $campaign->featured_image_url }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover opacity-60">
        @else
            <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover opacity-60">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-[#141b2b] via-[#141b2b]/40 to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 w-full pb-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-wrap items-center gap-4 mb-8">
                    <span class="px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-[#9be9bf]/20 text-[#9be9bf] backdrop-blur-md border border-[#9be9bf]/30">
                        {{ ucfirst($campaign->status) }}
                    </span>
                    <span class="text-white/80 text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">calendar_today</span>
                        {{ $campaign->start_date->format('M d') }} — {{ $campaign->end_date->format('M d, Y') }}
                    </span>
                </div>
                <h1 class="font-h1 text-h2 md:text-h1 text-white leading-tight max-w-4xl tracking-tighter italic">
                    {{ $campaign->title }}
                </h1>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 -mt-20 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-8 space-y-12">
                <!-- Overview Card -->
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
                    <div class="p-12">
                        <h2 class="font-h3 text-h3 text-on-background mb-8 tracking-tight">Project Overview</h2>
                        <div class="font-body-base text-body-base text-on-surface-variant leading-relaxed prose prose-green max-w-none">
                            {!! $campaign->description !!}
                        </div>
                    </div>
                </div>

                <!-- Beneficiary Map -->
                <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden p-12">
                    <h3 class="font-h3 text-h3 text-on-background mb-8 tracking-tight italic">Where Your Donation Goes</h3>
                    @include('components.beneficiary-map', [
                        'locations' => $locations,
                        'mapId'     => 'campaign-detail',
                        'height'    => '400px',
                    ])
                </div>

                <!-- Donation Interface -->
                <livewire:donation-form :campaignId="$campaign->id" />

                <!-- Impact Reports Section -->
                @if($campaign->impactReports->count())
                    <div class="space-y-8">
                        <h2 class="font-h3 text-h3 text-on-background tracking-tight">Verified Impact Updates</h2>
                        <div class="grid grid-cols-1 gap-8">
                            @foreach($campaign->impactReports as $report)
                                <div class="bg-white rounded-[2rem] shadow-md border border-gray-100 p-10 flex flex-col md:flex-row gap-10 items-center transition-transform hover:-translate-y-1">
                                    <div class="flex-shrink-0 text-center md:text-left bg-[#a5f3c9]/30 p-8 rounded-3xl">
                                        <div class="font-h1 text-h2 text-primary mb-1">{{ number_format($report->beneficiary_count) }}</div>
                                        <div class="font-label-xs text-[10px] text-on-surface-variant uppercase tracking-widest font-bold">Beneficiaries</div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-3">
                                            <span class="material-symbols-outlined text-[#1a6b4a] text-lg">verified</span>
                                            <span class="font-label-xs text-[10px] text-[#1a6b4a] uppercase tracking-widest font-black">Impact Verified</span>
                                        </div>
                                        <h3 class="font-h4 text-xl text-on-background mb-4">Milestone Achieved</h3>
                                        <p class="font-body-sm text-body-sm text-on-surface-variant leading-relaxed mb-6">
                                            {{ Str::limit($report->summary, 200) }}
                                        </p>
                                        <a href="/campaigns/{{ $campaign->slug }}/impact" class="inline-flex items-center gap-2 font-bold text-[#1a6b4a] hover:gap-3 transition-all">
                                            Evidence & Ledger Data
                                            <span class="material-symbols-outlined text-lg">arrow_forward</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-4">
                <div class="sticky top-24 space-y-8">
                    <!-- Donation Progress Card -->
                    <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 p-10 relative overflow-hidden">
                        <div class="absolute -top-12 -right-12 w-48 h-48 bg-[#a5f3c9] rounded-full blur-[80px] opacity-20"></div>
                        
                        <livewire:campaign-progress-bar :campaignId="$campaign->id" />

                        @if($campaign->isActive())
                            <div class="mt-10 space-y-4">
                                <a href="#donate" class="block w-full bg-[#f59e0b] text-white text-center py-5 rounded-2xl font-bold text-lg shadow-lg hover:shadow-2xl active:scale-95 transition-all">
                                    Donate Now
                                </a>
                                <div class="flex items-center justify-center gap-2 text-[10px] text-on-surface-variant font-bold uppercase tracking-widest">
                                    <span class="material-symbols-outlined text-sm">lock</span>
                                    Secure Stripe Checkout
                                </div>
                            </div>
                        @else
                            <div class="mt-10 p-6 bg-gray-50 rounded-2xl border border-dashed border-gray-200 text-center">
                                <p class="text-sm font-bold text-on-surface-variant uppercase tracking-widest italic">Campaign Concluded</p>
                            </div>
                        @endif

                        <!-- Sharing -->
                        <div class="mt-10 pt-10 border-t border-gray-50">
                            <h4 class="font-label-xs text-[10px] text-on-surface-variant mb-6 uppercase tracking-[0.2em] font-bold">Amplify this project</h4>
                            <div class="flex gap-4">
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($campaign->title) }}&url={{ urlencode($meta['url'] ?? '') }}" target="_blank" class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-on-surface-variant hover:bg-[#141b2b] hover:text-white transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-xl">share</span>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($meta['url'] ?? '') }}" target="_blank" class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-on-surface-variant hover:bg-[#1877f2] hover:text-white transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-xl">public</span>
                                </a>
                                <button onclick="navigator.clipboard.writeText('{{ $meta['url'] ?? '' }}')" class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-on-surface-variant hover:bg-[#005235] hover:text-white transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-xl">content_copy</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity Card -->
                    <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                            <h3 class="font-label-xs text-[10px] text-on-background uppercase tracking-[0.2em] font-black flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-xl">bolt</span>
                                Real-Time Feed
                            </h3>
                            <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                        </div>
                        <div class="p-8">
                            <livewire:donation-feed :campaignId="$campaign->id" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
