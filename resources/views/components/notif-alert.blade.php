{{-- components/notif-alert.blade.php --}}
@php
    $message = session('success') ?? session('error');
    $type = session('success') ? 'success' : 'danger';
@endphp

@if ($message)
    <div {{ $attributes->merge([
        'class' => 'alert alert-dismissible fade show alert-' . $type,
        'role' => 'alert'
    ]) }}>
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
