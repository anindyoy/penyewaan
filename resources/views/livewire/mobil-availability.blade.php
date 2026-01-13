<div class="max-w-7xl mx-auto p-6 space-y-10">
    @php
        // Membuat array bantuan untuk meloop section
        $sections = [
            [
                'judul' => 'Hari Ini',
                'tanggal' => $tanggalHariIni->format('d M Y'),
                'tersedia' => $tersediaHariIni,
                'dipakai' => $dipakaiHariIni,
            ],
            [
                'judul' => 'Besok',
                'tanggal' => $tanggalBesok->format('d M Y'),
                'tersedia' => $tersediaBesok,
                'dipakai' => $dipakaiBesok,
            ],
        ];
    @endphp

    @foreach($sections as $section)
        <div>
            <h2 class="text-xl font-semibold mb-4">
                Ketersediaan Mobil - {{ $section['judul'] }} ({{ $section['tanggal'] }})
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Komponen Tersedia --}}
                @include('partials.mobil-card', [
                    'title' => 'Tersedia',
                    'icon' => '✅',
                    'colorClass' => 'green',
                    'data' => $section['tersedia'],
                    'emptyText' => 'Tidak ada mobil tersedia'
                ])

                {{-- Komponen Dipakai --}}
                @include('partials.mobil-card', [
                    'title' => 'Dipinjam',
                    'icon' => '🚫',
                    'colorClass' => 'red',
                    'data' => $section['dipakai'],
                    'emptyText' => 'Tidak ada mobil dipinjam'
                ])

            </div>
        </div>
    @endforeach

</div>