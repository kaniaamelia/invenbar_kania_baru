<div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $user->name) }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control"
           value="{{ old('email', $user->email) }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control"
           {{ isset($update) ? '' : 'required' }}>
</div>

<div class="mb-3">
    <label class="form-label">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" class="form-control"
           {{ isset($update) ? '' : 'required' }}>
</div>

<div class="mb-3">
    <label class="form-label">Role</label>
    <select name="role" class="form-select" required>
        <option value="">-- Pilih Role --</option>
        @foreach ($roles as $role)
            <option value="{{ $role }}"
                {{ old('role', $user->getRoleNames()->first()) == $role ? 'selected' : '' }}>
                {{ ucfirst($role) }}
            </option>
        @endforeach
    </select>
</div>

<div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i> Simpan
    </button>
</div>
