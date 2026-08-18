<x-guest-layout>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-2"
                     style="width:52px;height:52px;background:#198754;color:#fff;font-size:26px;">
                    <i class="bi bi-egg-fried"></i>
                </div>
                <h4 class="fw-bold mb-0">BukanAyam</h4>
                <small class="text-muted">Silakan login untuk melanjutkan</small>
            </div>

            @if (session('status'))
                <div class="alert alert-info py-2 small">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required autofocus>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">Ingat saya</label>
                </div>
                <button class="btn btn-success w-100">Masuk</button>
            </form>
        </div>
    </div>
</x-guest-layout>
