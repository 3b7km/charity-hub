@extends('layouts.app')

@section('title', 'Verify Donation Certificate — CharityHub')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-24 text-center">
    <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-8">
        <span class="material-symbols-outlined text-emerald-600 text-5xl">verified</span>
    </div>
    
    <h1 class="text-4xl font-black text-gray-900 mb-4 tracking-tight">Certificate Verified</h1>
    <p class="text-gray-500 mb-12 italic">This is an authentic contribution record from the CharityHub Public Ledger.</p>

    <div class="bg-white rounded-3xl shadow-xl border border-emerald-100 p-10 text-left overflow-hidden relative">
        <div class="absolute top-0 right-0 p-8 opacity-5">
            <span class="material-symbols-outlined text-9xl">workspace_premium</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 relative z-10">
            <div>
                <label class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest block mb-2">Donor</label>
                <div class="text-2xl font-black text-gray-900">{{ $donation->donor->name ?? 'Anonymous Donor' }}</div>
            </div>
            <div>
                <label class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest block mb-2">Amount</label>
                <div class="text-2xl font-black text-gray-900">{{ $donation->formatted_amount }}</div>
            </div>
            <div>
                <label class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest block mb-2">Campaign</label>
                <div class="text-xl font-bold text-gray-800">{{ $donation->campaign->title }}</div>
            </div>
            <div>
                <label class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest block mb-2">Verification ID</label>
                <div class="text-sm font-mono text-gray-400">{{ $donation->id }}</div>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-gray-50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-600 flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-xl">account_balance</span>
                </div>
                <div>
                    <div class="text-xs font-bold text-gray-900">CharityHub Foundation</div>
                    <div class="text-[10px] text-gray-400">Ledger Entry #{{ substr($donation->id, 0, 8) }}</div>
                </div>
            </div>
            <div class="text-xs font-bold text-emerald-600 flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">check_circle</span>
                Publicly Audited
            </div>
        </div>
    </div>

    <div class="mt-12">
        <a href="{{ route('transparency') }}" class="text-sm font-bold text-gray-500 hover:text-primary flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Back to Public Ledger
        </a>
    </div>
</div>
@endsection
