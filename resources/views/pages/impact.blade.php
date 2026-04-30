@extends('layouts.app')

@section('title', 'Our Global Impact — CharityHub')

@section('content')
<!-- Hero Section -->
<section class="bg-[#005235] py-32 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-[#8ad6ae] rounded-full blur-[100px] -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#8ad6ae] rounded-full blur-[100px] translate-x-1/2 translate-y-1/2"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        <span class="inline-block px-4 py-1.5 mb-8 rounded-full bg-[#9be9bf]/20 text-[#9be9bf] font-bold text-xs uppercase tracking-widest">Real-Time Data</span>
        <h1 class="text-5xl md:text-7xl font-black mb-8 tracking-tighter italic leading-tight">Impact in Numbers.</h1>
        <p class="text-xl text-[#a5f3c9] max-w-2xl mx-auto mb-16 opacity-90 leading-relaxed">We measure success by the lives we transform and the sustainable systems we build together.</p>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-5xl mx-auto border-t border-white/10 pt-16">
            <div>
                <div class="font-h1 text-h2 md:text-h1 text-[#9be9bf] mb-2 leading-none">£{{ number_format($stats['total_raised'] / 100, 1) }}{{ $stats['total_raised'] > 1000000 ? 'M' : '' }}</div>
                <div class="font-label-xs text-label-xs uppercase tracking-[0.2em] text-[#a5f3c9]">Total Raised</div>
            </div>
            <div>
                <div class="font-h1 text-h2 md:text-h1 text-[#9be9bf] mb-2 leading-none">{{ $stats['campaign_count'] }}</div>
                <div class="font-label-xs text-label-xs uppercase tracking-[0.2em] text-[#a5f3c9]">Active Projects</div>
            </div>
            <div>
                <div class="font-h1 text-h2 md:text-h1 text-[#9be9bf] mb-2 leading-none">{{ number_format($stats['donor_count']) }}</div>
                <div class="font-label-xs text-label-xs uppercase tracking-[0.2em] text-[#a5f3c9]">Global Donors</div>
            </div>
            <div>
                <div class="font-h1 text-h2 md:text-h1 text-[#9be9bf] mb-2 leading-none">{{ number_format($stats['beneficiary_count'] / 1000000, 1) }}M</div>
                <div class="font-label-xs text-label-xs uppercase tracking-[0.2em] text-[#a5f3c9]">Beneficiaries</div>
            </div>
        </div>
    </div>
</section>

<!-- Stories Section -->
<section class="py-32 bg-background px-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
            <div class="max-w-2xl">
                <h2 class="font-h2 text-h2 text-on-background mb-6 tracking-tight">Verified Stories of Change</h2>
                <p class="font-body-base text-body-base text-on-surface-variant leading-relaxed">Every project on CharityHub includes a verified impact report with on-the-ground photos, ledger statements, and direct beneficiary testimonials.</p>
            </div>
            <a href="{{ route('campaigns.index') }}" class="inline-flex items-center gap-2 bg-[#f59e0b] text-white font-bold px-8 py-4 rounded-xl shadow-md hover:shadow-xl transition-all active:scale-95">Support a Project</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @php
                $stories = [
                    ['title' => 'Rift Valley Wells', 'stat' => '5,400', 'label' => 'People with Water', 'img' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070&auto=format&fit=crop'],
                    ['title' => 'Education for All', 'stat' => '1,200', 'label' => 'Students Enrolled', 'img' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=2070&auto=format&fit=crop'],
                    ['title' => 'Mobile Health Clinic', 'stat' => '8,900', 'label' => 'Patients Treated', 'img' => 'https://images.unsplash.com/photo-1489710437720-ebb67ec84dd2?q=80&w=2070&auto=format&fit=crop'],
                ];
            @endphp

            @foreach($stories as $story)
                <div class="group bg-white rounded-[2rem] overflow-hidden border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col">
                    <div class="relative h-72 overflow-hidden">
                        <img src="{{ $story['img'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#141b2b]/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6 flex justify-between items-end">
                            <div class="text-white">
                                <h3 class="font-h4 text-h4 mb-1">{{ $story['title'] }}</h3>
                                <div class="font-label-xs text-[10px] uppercase tracking-widest text-[#9be9bf] font-bold">Report Verified</div>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white">
                                <span class="material-symbols-outlined text-lg">check_circle</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-10 text-center flex-grow flex flex-col justify-center">
                        <div class="font-h1 text-h2 text-primary mb-2">{{ $story['stat'] }}</div>
                        <div class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest mb-8">{{ $story['label'] }}</div>
                        <div class="mt-auto pt-6 border-t border-gray-50">
                            <a href="#" class="inline-flex items-center gap-2 font-bold text-[#1a6b4a] hover:gap-3 transition-all group-hover:text-[#005235]">
                                Read Case Study
                                <span class="material-symbols-outlined text-lg">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
