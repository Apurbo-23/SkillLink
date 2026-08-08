<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #D4AF37;">Post a Listing</h2>
    </x-slot>

    <style>
        body,
        .bg-gray-100 { background-color: #0B0A09 !important; }

        .bg-white {
            background-color: #121110 !important;
            border: 1px solid rgba(212, 175, 55, 0.15);
        }
        .text-gray-700,
        .text-sm.font-medium { color: #9a8a6a !important; }

        input[type="text"],
        textarea,
        select {
            background-color: #1a1814 !important;
            border: 1.5px solid rgba(212, 175, 55, 0.25) !important;
            color: #e8dfc8 !important;
            border-radius: 0.375rem !important;
            width: 100% !important;
            padding: 0.5rem 0.7rem !important;
            box-shadow: none !important;
            outline: none !important;
        }
        input[type="text"]:focus,
        textarea:focus,
        select:focus {
            border-color: #D4AF37 !important;
            box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.18) !important;
        }
        select option { background-color: #1a1814; color: #e8dfc8; }
    </style>

    <div class="py-8 max-w-xl mx-auto px-4" style="background-color: #0B0A09; min-height: 100vh;">
        @if ($errors->any())
            <div class="mb-4 p-4 rounded" style="background-color:#1a1814; color:#f5b7b1; border:1px solid rgba(220,38,38,0.3);">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('listings.store') }}" class="space-y-4 p-6 rounded shadow" style="background-color:#121110; border:1px solid rgba(212,175,55,0.15);">
            @csrf

            <div>
                <label class="block font-medium text-sm mb-1" style="color:#9a8a6a;">Skill you're offering</label>
                <input type="text" name="skill_offered" required value="{{ old('skill_offered') }}">
            </div>

            <div>
                <label class="block font-medium text-sm mb-1" style="color:#9a8a6a;">Skill you want in return</label>
                <input type="text" name="skill_wanted" required value="{{ old('skill_wanted') }}">
            </div>

            <div>
                <label class="block font-medium text-sm mb-1" style="color:#9a8a6a;">Category</label>
                <select name="category" required>
                    <option>Programming</option>
                    <option>Design</option>
                    <option>Marketing</option>
                    <option>Languages</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-sm mb-1" style="color:#9a8a6a;">Description (optional)</label>
                <textarea name="description" rows="3">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="px-4 py-2 rounded font-semibold"
                style="background-color:rgba(212,175,55,0.12); border:1.5px solid #D4AF37; color:#D4AF37;">
                Post Listing
            </button>
        </form>
    </div>
</x-app-layout>