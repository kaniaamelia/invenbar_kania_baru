<x-app-layout>
    <x-slot name="header">
        <h2 class="h5 mb-0">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center">
    <div class="col">
        @if (Route::has('profile.destroy'))
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        @endif
    </div>
</div>


            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
