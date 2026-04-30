{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="rounded-xl border border-gray-200 overflow-hidden shadow-sm">

    {{-- Map Header --}}
    <div class="bg-white px-4 py-3 border-b border-gray-200 flex items-center gap-2">
        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <span class="text-sm font-medium text-gray-700">Beneficiary Locations</span>
        <span class="ml-auto text-xs text-gray-500">{{ $locations->sum('beneficiary_count') }} total beneficiaries</span>
    </div>

    @if($locations->count() > 0)
        {{-- Map Container --}}
        <div id="beneficiary-map-{{ $mapId ?? 'default' }}"
             style="height: {{ $height ?? '400px' }}; width: 100%;">
        </div>
    @else
        <div class="flex flex-col items-center justify-center bg-gray-50 border-t border-gray-100 p-12 text-center" style="height: {{ $height ?? '400px' }};">
            <span class="material-symbols-outlined text-gray-300 text-5xl mb-4">location_off</span>
            <p class="font-body-base text-gray-500 font-medium">No locations mapped yet.</p>
        </div>
    @endif

    {{-- Location List Below Map --}}
    @if($locations->count() > 0)
    <div class="bg-white border-t border-gray-100 divide-y divide-gray-50">
        @foreach($locations as $location)
        <div class="px-4 py-2 flex items-center justify-between text-sm">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span class="text-gray-700">{{ $location->location_name }}</span>
            </div>
            <span class="font-medium text-emerald-700">{{ number_format($location->beneficiary_count) }} helped</span>
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mapId = 'beneficiary-map-{{ $mapId ?? 'default' }}';
    const locations = @json($locations);

    if (!locations || !locations.length) {
        console.warn('No locations found for map:', mapId);
        return;
    }

    const mapContainer = document.getElementById(mapId);
    if (!mapContainer) return;

    // Initialize Map
    const map = L.map(mapId).setView(
        [parseFloat(locations[0].latitude), parseFloat(locations[0].longitude)],
        6
    );

    // OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 18,
    }).addTo(map);

    // Custom emerald marker icon
    const emeraldIcon = L.divIcon({
        html: `<div style="background-color: #10b981; width: 16px; height: 16px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"></div>`,
        className: '',
        iconSize: [16, 16],
        iconAnchor: [8, 8],
    });

    // Add markers
    const markers = locations.map(loc => {
        return L.marker([parseFloat(loc.latitude), parseFloat(loc.longitude)], { icon: emeraldIcon })
            .addTo(map)
            .bindPopup(`
                <div style="padding: 4px;">
                    <h4 style="margin:0; font-weight:bold; color:#111;">${loc.location_name}</h4>
                    <p style="margin:4px 0 0; color:#059669; font-weight:bold;">${loc.beneficiary_count.toLocaleString()} beneficiaries</p>
                </div>
            `);
    });

    // Auto-fit map
    if (markers.length > 1) {
        const group = L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.2));
    }

    // CRITICAL: Fix for the "white box" issue
    setTimeout(() => {
        map.invalidateSize();
    }, 200);
});
</script>
