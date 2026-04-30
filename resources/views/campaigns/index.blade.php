@extends('layouts.app')

@section('title', 'Campaigns — CharityHub')
@section('meta_description', 'Browse active fundraising campaigns and make a difference today.')

@section('content')
<!-- Header Section -->
<section class="bg-white border-b border-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="font-h1 text-h1 text-on-background mb-2 leading-tight">Our Campaigns</h1>
                <p class="font-body-base text-body-base text-on-surface-variant max-w-2xl">Discover and support projects that create lasting change. Every donation is tracked with radical transparency to ensure your impact is real.</p>
            </div>
            <div class="inline-flex items-center gap-2 bg-secondary-container text-on-secondary-container px-4 py-2 rounded-full shadow-sm">
                <span class="font-label-md text-label-md">24 Active Campaigns</span>
            </div>
        </div>
    </div>
</section>

@livewire('campaign-grid')

@endsection
