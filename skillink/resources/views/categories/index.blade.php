<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Skill Categories
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse ($categories as $category)

                    <a
                        href="{{ route('categories.show', $category) }}"
                        class="block bg-white rounded-xl shadow-sm border border-gray-100 p-6
                               hover:shadow-md hover:border-indigo-200 transition"
                    >

                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $category }}
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Browse {{ $category }} skills
                        </p>

                        <div class="mt-4 text-indigo-600 text-sm font-medium">
                            View listings →
                        </div>

                    </a>

                @empty

                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500">
                            No skill categories available yet.
                        </p>
                    </div>

                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>
