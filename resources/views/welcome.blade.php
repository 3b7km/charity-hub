@extends('layouts.app')

@section('title', 'CharityHub - Transparent Giving for Real Change')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-b from-[#a5f3c9] to-background pt-24 pb-40 px-6">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-20 items-center">
        <div class="z-10 text-center lg:text-left">
            <span class="inline-block px-4 py-2 mb-8 rounded-full bg-[#9be9bf]/30 text-[#005235] font-black text-xs uppercase tracking-widest border border-[#1a6b4a]/10">Trusted by 12,000+ Active Donors</span>
            <h1 class="font-h1 text-h1 md:text-6xl text-on-background mb-8 leading-[1.1] tracking-tighter italic">
                Every Donation <br class="hidden lg:block"/> Creates <span class="text-[#1a6b4a]">Real Change.</span>
            </h1>
            <p class="font-body-base text-xl text-on-surface-variant mb-12 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                Join a global community dedicated to radical transparency. Follow every pound from your wallet to the person who needs it most.
            </p>
            <div class="flex flex-wrap justify-center lg:justify-start gap-6">
                <a href="{{ route('campaigns.index') }}" class="px-12 py-5 bg-[#f59e0b] text-white font-bold rounded-2xl shadow-lg hover:shadow-2xl transition-all active:scale-95 text-lg">Browse Campaigns</a>
                <a href="{{ route('impact') }}" class="px-12 py-5 border-2 border-[#1a6b4a] text-[#1a6b4a] font-bold rounded-2xl hover:bg-emerald-50 transition-all text-center text-lg">See Our Impact</a>
            </div>
        </div>
        <div class="relative group">
            <div class="aspect-square rounded-[3.5rem] overflow-hidden shadow-[0_50px_100px_rgba(0,0,0,0.15)] relative border-[12px] border-white">
                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000" src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070&auto=format&fit=crop" alt="Impact Photography"/>
                
                <!-- Floating Notification -->
                @livewire('donation-feed')
            </div>
            <!-- Decorative Glow -->
            <div class="absolute -top-10 -right-10 w-48 h-48 bg-[#f59e0b] rounded-full blur-[100px] opacity-20 -z-10"></div>
            <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-[#1a6b4a] rounded-full blur-[100px] opacity-20 -z-10"></div>
        </div>
    </div>
</section>

<!-- Impact Counter Strip -->
<section class="bg-[#1a6b4a] py-20 px-6 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 100 C 20 0 50 0 100 100 Z" fill="currentColor"></path>
        </svg>
    </div>
    <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-12 relative z-10">
        <div class="text-center">
            <p class="font-h1 text-4xl md:text-5xl text-[#9be9bf] mb-2 leading-none tracking-tighter">£12.4M</p>
            <p class="font-label-xs text-[10px] text-[#a5f3c9] uppercase tracking-[0.25em] font-black">Total Raised</p>
        </div>
        <div class="text-center border-l border-white/10">
            <p class="font-h1 text-4xl md:text-5xl text-[#9be9bf] mb-2 leading-none tracking-tighter">842</p>
            <p class="font-label-xs text-[10px] text-[#a5f3c9] uppercase tracking-[0.25em] font-black">Campaigns Funded</p>
        </div>
        <div class="text-center border-l border-white/10">
            <p class="font-h1 text-4xl md:text-5xl text-[#9be9bf] mb-2 leading-none tracking-tighter">12k+</p>
            <p class="font-label-xs text-[10px] text-[#a5f3c9] uppercase tracking-[0.25em] font-black">Global Donors</p>
        </div>
        <div class="text-center border-l border-white/10">
            <p class="font-h1 text-4xl md:text-5xl text-[#9be9bf] mb-2 leading-none tracking-tighter">1.2M</p>
            <p class="font-label-xs text-[10px] text-[#a5f3c9] uppercase tracking-[0.25em] font-black">Beneficiaries</p>
        </div>
    </div>
</section>

<!-- Featured Campaigns -->
<section class="py-32 px-6 bg-background">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
            <div class="max-w-2xl">
                <span class="font-label-xs text-[#1a6b4a] uppercase tracking-widest font-black mb-4 block">Crowdfunding Impact</span>
                <h2 class="font-h2 text-h2 text-on-background tracking-tight italic mb-6">Active Initiatives</h2>
                <p class="font-body-base text-on-surface-variant leading-relaxed">Urgent projects requiring immediate support to reach critical milestones and deliver life-changing aid.</p>
            </div>
            <a href="{{ route('campaigns.index') }}" class="hidden md:flex items-center gap-3 bg-[#1a6b4a]/5 text-[#1a6b4a] px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#1a6b4a]/10 transition-all group">
                View All Projects 
                <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
        </div>
        
        <div class="grid md:grid-cols-3 gap-12">
            @foreach(\App\Models\Campaign::active()->take(3)->get() as $campaign)
                <div class="bg-white rounded-[2.5rem] shadow-sm overflow-hidden flex flex-col group transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 border border-gray-50">
                    <div class="h-64 relative overflow-hidden">
                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" src="{{ $campaign->getFirstMediaUrl('featured') ?: 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070&auto=format&fit=crop' }}" alt="{{ $campaign->title }}"/>
                        <div class="absolute top-6 left-6">
                            <span class="bg-[#141b2b] text-white text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-xl shadow-2xl backdrop-blur-md border border-white/10">{{ $campaign->category ?? 'Impact' }}</span>
                        </div>
                    </div>
                    <div class="p-10 flex flex-col flex-grow">
                        <h3 class="font-h4 text-2xl text-on-background mb-4 leading-tight group-hover:text-primary transition-colors">{{ $campaign->title }}</h3>
                        <p class="font-body-sm text-on-surface-variant line-clamp-2 mb-10 leading-relaxed">{{ strip_tags($campaign->description) }}</p>
                        
                        <div class="mt-auto space-y-8">
                            <div>
                                <div class="flex justify-between items-end mb-3">
                                    <span class="font-monetary text-xl text-[#1a6b4a] font-black">{{ $campaign->formatted_raised }}</span>
                                    <span class="font-label-xs text-[10px] text-gray-400 uppercase tracking-widest font-black">{{ $campaign->progress_percentage }}% Reached</span>
                                </div>
                                <div class="w-full h-2.5 bg-gray-50 rounded-full overflow-hidden shadow-inner border border-gray-100">
                                    <div class="h-full bg-[#005235] rounded-full transition-all duration-1000" style="width: {{ $campaign->progress_percentage }}%"></div>
                                </div>
                            </div>
                            <a href="{{ route('campaigns.show', $campaign) }}" class="block w-full text-center py-5 bg-[#141b2b] text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-md hover:bg-primary transition-all active:scale-95">Support Project</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-32 px-6 bg-white border-y border-gray-50 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#a5f3c9] rounded-full blur-[150px] opacity-10"></div>
    <div class="max-w-7xl mx-auto text-center mb-24 relative z-10">
        <span class="font-label-xs text-[#1a6b4a] uppercase tracking-widest font-black mb-4 block">Transparency First</span>
        <h2 class="font-h2 text-h2 text-on-background tracking-tight italic mb-6">How Your Support Works</h2>
        <p class="font-body-base text-on-surface-variant max-w-2xl mx-auto">We've built a three-step process designed to give you complete peace of mind and maximum impact visibility.</p>
    </div>
    <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-20 relative z-10">
        <div class="space-y-8 text-center group">
            <div class="w-24 h-24 bg-[#a5f3c9] text-[#005235] rounded-[2rem] flex items-center justify-center mx-auto shadow-sm rotate-3 group-hover:rotate-0 transition-all duration-500">
                <span class="material-symbols-outlined text-5xl">search</span>
            </div>
            <h4 class="font-h4 text-2xl tracking-tight">Choose a Cause</h4>
            <p class="font-body-sm text-on-surface-variant leading-relaxed">Browse verified campaigns vetted by our transparency experts and select the one that moves you.</p>
        </div>
        <div class="space-y-8 text-center group">
            <div class="w-24 h-24 bg-[#a5f3c9] text-[#005235] rounded-[2rem] flex items-center justify-center mx-auto shadow-sm -rotate-3 group-hover:rotate-0 transition-all duration-500">
                <span class="material-symbols-outlined text-5xl">security</span>
            </div>
            <h4 class="font-h4 text-2xl tracking-tight">Secure Donation</h4>
            <p class="font-body-sm text-on-surface-variant leading-relaxed">Your contribution is processed via encrypted channels directly into the campaign's dedicated fund.</p>
        </div>
        <div class="space-y-8 text-center group">
            <div class="w-24 h-24 bg-[#a5f3c9] text-[#005235] rounded-[2rem] flex items-center justify-center mx-auto shadow-sm rotate-6 group-hover:rotate-0 transition-all duration-500">
                <span class="material-symbols-outlined text-5xl">description</span>
            </div>
            <h4 class="font-h4 text-2xl tracking-tight">Receive Report</h4>
            <p class="font-body-sm text-on-surface-variant leading-relaxed">Get detailed financial statements and photo/video evidence showing exactly how your funds were spent.</p>
        </div>
    </div>
</section>

<!-- Volunteer Banner -->
<section class="py-32 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-[#141b2b] rounded-[4rem] p-20 text-white relative overflow-hidden flex flex-col lg:grid lg:grid-cols-12 items-center gap-16">
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#1a6b4a] rounded-full blur-[100px] opacity-30"></div>
            <div class="lg:col-span-7 relative z-10 text-center lg:text-left">
                <h2 class="font-h1 text-h1 md:text-6xl mb-8 tracking-tighter italic leading-[1.1]">Can't donate?<br/><span class="text-[#a5f3c9]">Give your time.</span></h2>
                <p class="text-gray-400 text-xl leading-relaxed max-w-xl">Join 4,200+ volunteers across the globe making an impact through digital advocacy and on-ground relief efforts.</p>
            </div>
            <div class="lg:col-span-5 flex flex-col items-center gap-8 relative z-10 w-full">
                <a href="{{ route('volunteer.dashboard') }}" class="w-full py-6 bg-white text-[#141b2b] font-black text-xs uppercase tracking-[0.2em] rounded-[2rem] hover:shadow-2xl transition-all active:scale-95 text-center shadow-xl">Become a Volunteer</a>
                <div class="flex items-center gap-3">
                    <div class="flex -space-x-3">
                        @for($i=1; $i<=4; $i++)
                            <div class="w-10 h-10 rounded-full border-2 border-[#141b2b] overflow-hidden bg-gray-800">
                                <img src="https://i.pravatar.cc/100?img={{ $i+20 }}" alt="user"/>
                            </div>
                        @endfor
                    </div>
                    <span class="text-sm font-black text-[#a5f3c9] uppercase tracking-widest">248 open opportunities</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

