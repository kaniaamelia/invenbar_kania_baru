@props(['judul', 'jumlah', 'kondisi', 'color'])

<h4 class="small font-weight-bold">
    {{ $judul }}
    <span class="float-end">{{ $kondisi }}</span>
</h4>

@php
    $persen = $jumlah > 0 ? ($kondisi / $jumlah) * 100 : 0;
@endphp

<div class="progress mb-4">
    <div class="progress-bar bg-{{ $color }}"
         role="progressbar"
         style="width: {{ $persen }}%;"
         aria-valuenow="{{ $persen }}"
         aria-valuemin="0"
         aria-valuemax="100">
    </div>
</div>
