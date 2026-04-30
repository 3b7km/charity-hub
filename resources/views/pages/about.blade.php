@extends('layouts.app')

@section('title', 'About Us — CharityHub')

@section('content')
<!-- Hero Section -->
<section class="bg-[#005235] py-32 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-[#8ad6ae] rounded-full blur-[100px] -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-[#8ad6ae] rounded-full blur-[100px] translate-x-1/2 translate-y-1/2"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        <span class="inline-block px-4 py-1.5 mb-8 rounded-full bg-[#9be9bf]/20 text-[#9be9bf] font-bold text-xs uppercase tracking-widest">Our Story</span>
        <h1 class="text-5xl md:text-7xl font-black mb-8 tracking-tighter italic leading-tight">We Bridge the Gap.</h1>
        <p class="text-xl text-[#a5f3c9] max-w-2xl mx-auto leading-relaxed opacity-90">
            CharityHub was founded on a simple belief: giving should be transparent, effective, and deeply personal. We're not just a platform; we're a movement.
        </p>
    </div>
</section>

<!-- Content Section -->
<section class="py-32 max-w-7xl mx-auto px-6 bg-background">
    <div class="grid lg:grid-cols-2 gap-20 items-center">
        <div class="relative">
            <div class="aspect-[4/5] rounded-[3rem] overflow-hidden shadow-2xl">
                <img src="https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover" alt="Team meeting"/>
            </div>
            <div class="absolute -bottom-10 -right-10 bg-[#1a6b4a] p-10 rounded-[2rem] text-white shadow-xl max-w-xs hidden md:block">
                <p class="text-3xl font-black mb-2">100%</p>
                <p class="text-sm font-bold opacity-80 uppercase tracking-widest">Commitment to Integrity</p>
            </div>
        </div>
        
        <div class="space-y-10">
            <div>
                <h2 class="font-h2 text-h2 text-on-background mb-6 tracking-tight">Our Mission</h2>
                <div class="space-y-6 font-body-base text-body-base text-on-surface-variant leading-relaxed">
                    <p>
                        The traditional charity model is broken. Donors feel disconnected from their impact, and organizations struggle to prove where the money goes. <strong class="text-primary">CharityHub solves this through radical transparency.</strong>
                    </p>
                    <p>
                        By leveraging real-time tracking, immutable ledgers, and verified impact reports, we ensure that every penny you contribute is accounted for and translated into real-world change.
                    </p>
                </div>
            </div>
            
            <div class="grid sm:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm group hover:shadow-md transition-all">
                    <div class="w-12 h-12 rounded-xl bg-[#a5f3c9] flex items-center justify-center text-[#005235] mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">verified_user</span>
                    </div>
                    <h3 class="font-h4 text-xl text-on-background mb-3">Radical Integrity</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">We don't hide behind jargon. Our records are open, and our impact is verified.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm group hover:shadow-md transition-all">
                    <div class="w-12 h-12 rounded-xl bg-[#a5f3c9] flex items-center justify-center text-[#005235] mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">favorite</span>
                    </div>
                    <h3 class="font-h4 text-xl text-on-background mb-3">Human Centered</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Technology is just a tool. Our focus is always on the humans behind the stats.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-32 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-[#141b2b] rounded-[4rem] p-20 text-white relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-12">
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary rounded-full blur-[150px] opacity-20"></div>
            <div class="relative z-10 max-w-2xl text-center md:text-left">
                <h2 class="text-4xl md:text-6xl font-black mb-8 tracking-tighter italic leading-tight">Ready to join the movement?</h2>
                <p class="text-gray-400 text-lg leading-relaxed">Whether through donation or volunteering, your involvement starts a ripple of change that spans the globe.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-6 relative z-10">
                <a href="{{ route('campaigns.index') }}" class="px-12 py-5 bg-[#f59e0b] text-white font-bold rounded-xl shadow-lg hover:shadow-2xl transition-all active:scale-95 text-center">Start Giving</a>
                <a href="{{ route('volunteer.dashboard') }}" class="px-12 py-5 bg-white/10 text-white font-bold rounded-xl backdrop-blur-md hover:bg-white/20 transition-all text-center">Apply to Volunteer</a>
            </div>
        </div>
    </div>
</section>

@endsection
