<x-app-layout>
    <x-slot name="header"><h2 style="color:#D4AF37;">Disputes</h2></x-slot>
    <style>body,.bg-gray-100{background-color:#0B0A09!important;}.bg-white{background-color:#121110!important;border:1px solid rgba(212,175,55,0.15);}</style>
    <div class="py-8 max-w-4xl mx-auto px-4" style="background-color:#0B0A09; min-height:100vh;">
        @foreach ($disputes as $dispute)
            <div class="p-4 rounded mb-4" style="background-color:#121110; border:1px solid rgba(212,175,55,0.15);">
                <p style="color:#e8dfc8;"><strong>{{ $dispute->raisedBy->name }}</strong> — {{ $dispute->reason }}</p>
                <form method="POST" action="{{ route('admin.disputes.resolve', $dispute) }}" class="mt-2">
                    @csrf @method('PATCH')
                    <textarea name="admin_notes" placeholder="Admin notes..." style="background-color:#1a1814; color:#e8dfc8; border:1px solid rgba(212,175,55,0.25); width:100%; padding:0.4rem; border-radius:0.375rem;"></textarea>
                    <button name="status" value="resolved" class="mt-2 px-3 py-1 rounded text-sm" style="background-color:#D4AF37; color:#0B0A09;">Resolve</button>
                    <button name="status" value="dismissed" class="mt-2 px-3 py-1 rounded text-sm" style="background-color:#1a1814; color:#f5b7b1; border:1px solid rgba(220,38,38,0.3);">Dismiss</button>
                </form>
            </div>
        @endforeach
    </div>
</x-app-layout>