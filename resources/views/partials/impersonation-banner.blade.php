@auth
    @if (session()->has('impersonation') && (int) session('impersonation.target_id') === (int) auth()->id())
        <aside class="position-fixed bottom-0 end-0 m-3 p-3 bg-white border rounded shadow"
            style="z-index: 1040; max-width: calc(100% - 2rem);" aria-label="Account switching">
            <p class="mb-2 small">Logged in as <strong>{{ auth()->user()->name }}</strong></p>
            <form method="POST" action="{{ route('admin.impersonation.stop') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-brand-dark">Back to Super Admin</button>
            </form>
        </aside>
    @endif
@endauth
