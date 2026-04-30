<div id="donate" class="scroll-mt-24">
    @if($showSuccess)
        <div class="bg-emerald-50 border border-emerald-100 rounded-[2rem] p-10 text-center animate-in fade-in zoom-in duration-500">
            <div class="w-20 h-20 bg-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-emerald-200">
                <span class="material-symbols-outlined text-white text-4xl">check_circle</span>
            </div>
            <h3 class="font-h3 text-2xl text-on-background mb-2">Thank you, {{ $isAnonymous ? 'Kind Donor' : explode(' ', $fullName)[0] }}!</h3>
            <p class="font-body-base text-on-surface-variant mb-8">Your contribution of <span class="font-bold text-primary">£{{ number_format($amount) }}</span> has been processed and is now visible on our public ledger.</p>
            
            <div class="space-y-4">
                <button wire:click="$set('showSuccess', false)" class="w-full bg-primary text-white py-4 rounded-xl font-bold hover:shadow-lg transition-all">
                    Make Another Donation
                </button>
                <a href="{{ route('transparency') }}" class="block text-sm font-bold text-primary uppercase tracking-widest hover:underline">
                    View Real-Time Ledger
                </a>
            </div>
        </div>
    @else
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-10">
                <h3 class="font-h3 text-2xl text-on-background mb-8 tracking-tight">Support this Campaign</h3>
                
                <form wire:submit.prevent="processDonation" class="space-y-6">
                    <!-- Amount Presets -->
                    <div class="grid grid-cols-4 gap-3">
                        @foreach([10, 25, 50, 100] as $v)
                            <button type="button" 
                                wire:click="setAmount({{ $v }})"
                                class="py-3 rounded-xl border-2 font-bold transition-all {{ $amount == $v ? 'border-primary bg-primary/5 text-primary shadow-sm' : 'border-gray-100 text-on-surface-variant hover:border-primary/30' }}">
                                £{{ $v }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Custom Amount -->
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-on-surface-variant font-bold text-lg">£</span>
                        <input type="number" wire:model.live="amount" class="w-full pl-10 pr-5 py-4 rounded-2xl border-gray-100 focus:border-primary focus:ring-0 font-bold text-lg bg-gray-50/30" placeholder="Custom Amount">
                        @error('amount') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Personal Info -->
                    <div class="space-y-4">
                        <div>
                            <input type="text" wire:model="fullName" class="w-full px-5 py-4 rounded-2xl border-gray-100 focus:border-primary focus:ring-0 font-medium bg-gray-50/30" placeholder="Full Name">
                            @error('fullName') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input type="email" wire:model="email" class="w-full px-5 py-4 rounded-2xl border-gray-100 focus:border-primary focus:ring-0 font-medium bg-gray-50/30" placeholder="Email Address">
                            @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Anonymous Option -->
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" wire:model="isAnonymous" class="sr-only peer">
                            <div class="w-6 h-6 rounded-md border-2 border-gray-200 peer-checked:border-primary peer-checked:bg-primary transition-all"></div>
                            <span class="material-symbols-outlined absolute inset-0 text-white text-sm hidden peer-checked:flex items-center justify-center">check</span>
                        </div>
                        <span class="text-sm font-medium text-on-surface-variant group-hover:text-on-background transition-colors">Make my donation anonymous</span>
                    </label>

                    @if(session('error'))
                        <div class="p-4 bg-red-50 rounded-xl text-red-600 text-sm font-medium">
                            {{ session('error') }}
                        </div>
                    @endif

                    @guest
                        <a href="/admin/login" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-xl shadow-lg hover:shadow-2xl transition-all flex items-center justify-center gap-3">
                            <span class="material-symbols-outlined">login</span>
                            Login to Donate
                        </a>
                    @else
                        @php $campaign = \App\Models\Campaign::find($campaignId); @endphp
                        @if($campaign && $campaign->status === 'active' && (!$campaign->end_date || !$campaign->end_date->isPast()))
                            <button type="submit" class="w-full bg-[#f59e0b] text-white py-5 rounded-2xl font-black text-xl shadow-lg hover:shadow-2xl hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3">
                                <span class="material-symbols-outlined">favorite</span>
                                Confirm Donation
                            </button>
                        @else
                            <div class="p-6 bg-gray-50 border border-gray-100 rounded-2xl text-center">
                                <span class="material-symbols-outlined text-gray-400 text-3xl mb-2">lock</span>
                                <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Campaign No Longer Accepting Donations</p>
                            </div>
                        @endif
                    @endguest

                    <p class="text-[10px] text-center text-on-surface-variant font-bold uppercase tracking-widest opacity-60">
                        Secure SSL Encrypted Payment
                    </p>
                </form>
            </div>
        </div>
    @endif
</div>
