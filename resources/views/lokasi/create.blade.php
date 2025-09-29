<x-main-layout :title-page="__('Tambah Lokasi')">
    <div class="row">
        <form class="card col-lg-6" action="{{ route('lokasi.store') }}" method="POST">
            <div class="card-body">
                @csrf
                @include('lokasi.partials.form')
            </div>
        </form>
    </div>
</x-main-layout>
