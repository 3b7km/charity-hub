@extends('layouts.app')

@section('title', 'Donor Dashboard — CharityHub')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Welcome Back, {{ Auth::user()->name }}</h1>
            <p class="text-gray-500">Track your contributions and impact in real-time.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('campaigns.index') }}" class="px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm shadow-lg hover:shadow-xl transition-all">
                New Donation
            </a>
            <a href="{{ route('volunteer.dashboard') }}" class="px-6 py-3 bg-white text-gray-700 border border-gray-100 rounded-xl font-bold text-sm shadow-sm hover:bg-gray-50 transition-all">
                Volunteer Profile
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <span class="material-symbols-outlined text-6xl">payments</span>
            </div>
            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Total Donated</div>
            <div class="text-4xl font-black text-primary tracking-tighter">£{{ number_format($totalDonated / 100, 2) }}</div>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <span class="material-symbols-outlined text-6xl">favorite</span>
            </div>
            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Causes Supported</div>
            <div class="text-4xl font-black text-gray-900 tracking-tighter">{{ $campaignsCount }}</div>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <span class="material-symbols-outlined text-6xl">description</span>
            </div>
            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Certificates</div>
            <div class="text-4xl font-black text-gray-900 tracking-tighter">{{ $donations->where('status', 'confirmed')->count() }}</div>
        </div>
    </div>

    <!-- Donation History -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-900 tracking-tight text-center">Donation History</h2>
            <a href="{{ route('donor.donations.export') }}" class="text-xs font-bold uppercase tracking-widest text-primary hover:opacity-70 transition-opacity flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">download</span>
                Export All (PDF)
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Campaign</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Date</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Amount</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($donations as $donation)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="font-bold text-gray-900">{{ $donation->campaign->title }}</div>
                                <div class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $donation->id }}</div>
                            </td>
                            <td class="px-8 py-6 text-sm text-gray-500">
                                {{ $donation->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-8 py-6">
                                <span class="font-black text-gray-900">{{ $donation->formatted_amount }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-tighter {{ $donation->status === 'confirmed' ? 'bg-emerald-50 text-emerald-600' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $donation->status }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                @if($donation->status === 'confirmed')
                                    <a href="{{ route('donor.certificate.download', $donation->id) }}" class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:opacity-70">
                                        <span class="material-symbols-outlined text-sm">download</span>
                                        Certificate
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="material-symbols-outlined text-gray-200">volunteer_activism</span>
                                </div>
                                <p class="text-gray-400 font-medium italic">You haven't made any donations yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
