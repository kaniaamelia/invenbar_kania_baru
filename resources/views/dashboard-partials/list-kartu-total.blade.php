<div class="row">
    @php
        $kartus = [
            [
                'text' => 'TOTAL BARANG',
                'total' => $jumlahBarang,
                'route' => 'barang.index',
                'icon' => 'bi-box-seam',
                'color' => 'primary',
            ],
            [
                'text' => 'TOTAL KATEGORI',
                'total' => $jumlahKategori,
                'route' => 'kategori.index',
                'icon' => 'bi-tag',
                'color' => 'secondary',
            ],
            [
                'text' => 'TOTAL LOKASI',
                'total' => $jumlahLokasi,
                'route' => 'lokasi.index',
                'icon' => 'bi-geo-alt',
                'color' => 'success',
            ],
             // Tambahan: Peminjaman
            [
                'text' => 'TOTAL PEMINJAMAN',
                'total' => $jumlahPeminjaman ?? 0,
                'route' => 'peminjaman.index',
                'icon' => 'bi-journal-bookmark',
                'color' => 'info',
            ],
            // Tambahan: Pemeliharaan
            [
                'text' => 'TOTAL PEMELIHARAAN',
                'total' => $jumlahPemeliharaan ?? 0,
                'route' => 'pemeliharaan.index',
                'icon' => 'bi-tools',
                'color' => 'warning',
            ],
            [
                'text' => 'TOTAL USER',
                'total' => $jumlahUser,
                'route' => 'user.index',
                'icon' => 'bi-people',
                'color' => 'danger',
                'role' => 'admin',
            ],
           
        ];
    @endphp

    @foreach ($kartus as $kartu)
        @php extract($kartu); @endphp

        @isset($role)
            @role($role)
                <x-kartu-total :text="$text" :route="$route" :total="$total" :icon="$icon" :color="$color" />
            @endrole
        @else
            <x-kartu-total :text="$text" :route="$route" :total="$total" :icon="$icon" :color="$color" />
        @endisset
    @endforeach
</div>
