<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">Post a Listing</h2>
    </x-slot>

    <div class="py-8 max-w-xl mx-auto px-4">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('listings.store') }}" class="space-y-4 bg-white p-6 rounded shadow">
            @csrf

            <div>
                <label class="block font-medium text-sm text-gray-700">Skill you're offering</label>
                <input type="text" name="skill_offered" required class="mt-1 block w-full rounded border-gray-300" value="{{ old('skill_offered') }}">
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Skill you want in return</label>
                <input type="text" name="skill_wanted" required class="mt-1 block w-full rounded border-gray-300" value="{{ old('skill_wanted') }}">
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Category</label>
                <select name="category" required class="mt-1 block w-full rounded border-gray-300">
                    <option>Programming</option>
                    <option>Design</option>
                    <option>Marketing</option>
                    <option>Languages</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Description (optional)</label>
                <textarea name="description" rows="3" class="mt-1 block w-full rounded border-gray-300">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                Post Listing
            </button>
        </form>
    </div>
</x-app-layout>