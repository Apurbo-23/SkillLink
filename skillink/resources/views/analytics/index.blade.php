<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analytics Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Most Offered -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">

                        <h3 class="text-lg font-semibold mb-4">
                            Most Offered Skills
                        </h3>

                        @forelse ($mostOffered as $skill)
                            <div class="flex justify-between py-3 border-b">
                                <span>{{ $skill->skill_offered }}</span>
                                <span class="font-semibold">
                                    {{ $skill->total }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500">
                                No offered skills yet.
                            </p>
                        @endforelse

                    </div>
                </div>

                <!-- Most Wanted -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">

                        <h3 class="text-lg font-semibold mb-4">
                            Most In Demand Skills
                        </h3>

                        @forelse ($mostWanted as $skill)
                            <div class="flex justify-between py-3 border-b">
                                <span>{{ $skill->skill_wanted }}</span>
                                <span class="font-semibold">
                                    {{ $skill->total }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500">
                                No wanted skills yet.
                            </p>
                        @endforelse

                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
