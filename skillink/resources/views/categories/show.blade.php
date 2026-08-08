<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $category }} Skills
            </h2>

            <a
                href="{{ route('categories.index') }}"
                class="text-sm text-indigo-600 hover:text-indigo-800"
            >
                ← All Categories
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $category }}
                </h1>

                <p class="mt-1 text-gray-500">
                    Browse skills available in this category.
                </p>
            </div>

            @if ($listings->count())

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach ($listings as $listing)

                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

                            <div class="flex items-start justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $listing->skill_offered }}
                                </h3>

                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                    Active
                                </span>
                            </div>

                            <p class="mt-3 text-sm text-gray-600">
                                {{ $listing->description }}
                            </p>

                            <div class="mt-5 space-y-2 text-sm">

                                <div>
                                    <span class="font-medium text-gray-700">
                                        Offers:
                                    </span>

                                    <span class="text-gray-600">
                                        {{ $listing->skill_offered }}
                                    </span>
                                </div>

                                <div>
                                    <span class="font-medium text-gray-700">
                                        Looking for:
                                    </span>

                                    <span class="text-gray-600">
                                        {{ $listing->skill_wanted }}
                                    </span>
                                </div>

                                @if ($listing->user)
                                    <div>
                                        <span class="font-medium text-gray-700">
                                            Offered by:
                                        </span>

                                        <span class="text-gray-600">
                                            {{ $listing->user->name }}
                                        </span>
                                    </div>
                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="bg-white rounded-xl shadow-sm p-10 text-center">

                    <h3 class="text-lg font-semibold text-gray-900">
                        No listings found
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        There are currently no active listings in this category.
                    </p>

                    <a
                        href="{{ route('categories.index') }}"
                        class="inline-block mt-5 text-sm text-indigo-600 hover:text-indigo-800"
                    >
                        Browse other categories
                    </a>

                </div>

            @endif

        </div>
    </div>
</x-app-layout>
