<x-main-layout :title-page="__('Tambah User')">
    <div class="row">
        <form class="card col-lg-6" action="{{ route('user.store') }}" method="POST">
            <div class="card-body">
                @csrf
                @include('user.partials.form')
            </div>
        </form>
    </div>
</x-main-layout>
