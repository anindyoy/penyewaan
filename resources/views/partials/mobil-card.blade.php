<div class="bg-{{ $colorClass }}-50 border border-{{ $colorClass }}-200 rounded-lg p-4">
    <h3 class="font-semibold text-{{ $colorClass }}-700 mb-3">{{ $icon }} {{ $title }}</h3>

    <ul class="space-y-1 text-sm">
        @forelse($data as $mobil)
            <li>
                {{ $mobil->model }} {{ ucfirst($mobil->warna) }}
                <span class="text-gray-500">({{ $mobil->nomor_plat }})</span>
            </li>
        @empty
            <li class="text-gray-500 text-center py-2">{{ $emptyText }}</li>
        @endforelse
    </ul>
</div>