<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #D4AF37;">
            {{ __('Skill Selection') }}
        </h2>
    </x-slot>

    <style>
        /* ── Base page background ── */
        body,
        .bg-gray-100 { background-color: #0B0A09 !important; }

        /* ── Main card ── */
        .bg-white {
            background-color: #121110 !important;
            border: 1px solid rgba(212, 175, 55, 0.15);
        }

        /* ── Greeting text ── */
        .text-gray-900 { color: #e8dfc8 !important; }

        /* ── Tab buttons — default (inactive) ── */
        .tab-btn {
            background-color: #1a1814;
            border: 1.5px solid rgba(212, 175, 55, 0.2);
            color: #9a8a6a;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-weight: 500;
            box-shadow: 0 1px 3px rgba(0,0,0,0.4);
            transition: all 0.2s;
            width: 36rem;
            height: 4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 1rem;
            line-height: 1.2;
            cursor: pointer;
        }

        /* ── Tab buttons — active ── */
        .tab-btn.active,
        .tab-btn[data-active="true"] {
            background-color: rgba(212, 175, 55, 0.12);
            border-color: #D4AF37;
            color: #D4AF37;
        }

        .tab-btn:hover:not(.active) {
            background-color: #211f1b;
            border-color: rgba(212, 175, 55, 0.4);
            color: #c8b078;
        }

        /* ── Panel ── */
        .panel {
            background-color: #181612;
            border: 1px solid rgba(212, 175, 55, 0.15);
            border-radius: 0.5rem;
            padding: 1rem;
        }

        /* ── Panel heading ── */
        .panel-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #D4AF37;
        }

        /* ── Inner skill cards ── */
        .skill-card {
            background-color: #0f0e0c;
            border: 1px solid rgba(212, 175, 55, 0.12);
            border-radius: 0.5rem;
            padding: 1rem;
        }

        /* ── Labels ── */
        .text-gray-700,
        .text-sm.font-medium { color: #9a8a6a !important; }

        /* ── Selects ── */
        select,
        select.focus\:border-indigo-500,
        select.focus\:ring-indigo-500 {
            background-color: #1a1814 !important;
            border: 1.5px solid rgba(212, 175, 55, 0.25) !important;
            color: #e8dfc8 !important;
            border-radius: 0.375rem !important;
            width: 100% !important;
            padding: 0.4rem 0.6rem !important;
            box-shadow: none !important;
            outline: none !important;
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23D4AF37' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.7rem center;
            background-size: 1rem;
            padding-right: 2.2rem !important;
        }

        select:focus {
            border-color: #D4AF37 !important;
            box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.18) !important;
        }

        select option {
            background-color: #1a1814;
            color: #e8dfc8;
        }

        /* ── Header bar (Breeze default) ── */
        header.bg-white,
        nav.bg-white {
            background-color: #0f0e0c !important;
            border-bottom: 1px solid rgba(212, 175, 55, 0.12) !important;
            box-shadow: none !important;
        }

        /* ── Shadow on main card ── */
        .shadow-sm { box-shadow: 0 1px 8px rgba(0,0,0,0.5) !important; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background-color:#121110; border:1px solid rgba(212,175,55,0.15);">
                <div class="p-6" x-data="{ activeTab: 'searching' }">


                    {{-- ── TAB BUTTONS ── --}}
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <button
                            type="button"
                            class="tab-btn"
                            :class="activeTab === 'searching' ? 'active' : ''"
                            @click="activeTab = 'searching'"
                        >
                            Skills searching for
                        </button>

                        <button
                            type="button"
                            class="tab-btn"
                            :class="activeTab === 'offering' ? 'active' : ''"
                            @click="activeTab = 'offering'"
                        >
                            Skill to offer
                        </button>
                    </div>

                    {{-- ── SEARCHING PANEL ── --}}
                    <div x-show="activeTab === 'searching'" x-transition class="panel">
                        <h3 class="panel-title">Skills you're searching for</h3>
                        <div class="mt-4 space-y-4">
                            @for ($i = 0; $i < 3; $i++)
                                <div class="skill-card" x-data="{
                                    skillOptions: {
                                        Programming: ['Python', 'C', 'Java', 'JavaScript', 'PHP'],
                                        Design: ['UI/UX', 'Figma', 'Illustration', 'Branding', 'Motion'],
                                        Marketing: ['SEO', 'Content Marketing', 'Social Media', 'Email Marketing', 'Copywriting'],
                                        Languages: ['English', 'Spanish', 'French', 'Arabic', 'German']
                                    },
                                    selectedCategory: 'Programming',
                                    selectedSkill: 'Python'
                                }">
                                    <div class="grid gap-4 md:grid-cols-2">
                                        <div>
                                            <label for="search-skill-category-{{ $i }}"
                                                class="mb-1 block text-sm font-medium"
                                                style="color:#9a8a6a;">
                                                Skill Category
                                            </label>
                                            <select
                                                id="search-skill-category-{{ $i }}"
                                                x-model="selectedCategory"
                                                @change="selectedSkill = skillOptions[selectedCategory][0]"
                                            >
                                                <option>Programming</option>
                                                <option>Design</option>
                                                <option>Marketing</option>
                                                <option>Languages</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label for="search-skill-name-{{ $i }}"
                                                class="mb-1 block text-sm font-medium"
                                                style="color:#9a8a6a;">
                                                Skill Name
                                            </label>
                                            <select
                                                id="search-skill-name-{{ $i }}"
                                                x-model="selectedSkill"
                                            >
                                                <template x-for="skill in skillOptions[selectedCategory]" :key="skill">
                                                    <option :value="skill" x-text="skill"></option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                <!-- STATUS INDICATOR -->
                                    <div x-data="{ status: 'pending' }" class="border-t pt-3 mt-3" style="border-color: rgba(212, 175, 55, 0.15);">
                                        <div class="flex items-center gap-3">
                                            <!-- <span class="px-2 py-1 text-xs rounded font-semibold"
                                                :class="{
                                                    'bg-orange-100 text-orange-700': status === 'pending',
                                                    'bg-red-100 text-red-700': status === 'incomplete',
                                                    'bg-green-100 text-green-700': status === 'done'
                                                }"
                                                x-text="status.charAt(0).toUpperCase() + status.slice(1)">
                                            </span> -->
                                            <span class="px-2 py-1 text-xs rounded font-semibold"
                                                :style="{
                                                    'background-color': status === 'pending' ? 'rgba(212, 175, 55, 0.15)' : status === 'incomplete' ? 'rgba(220, 38, 38, 0.15)' : 'rgba(34, 197, 94, 0.15)',
                                                    'color': status === 'pending' ? '#D4AF37' : status === 'incomplete' ? '#f87171' : '#4ade80',
                                                    'border': '1px solid ' + (status === 'pending' ? 'rgba(212, 175, 55, 0.4)' : status === 'incomplete' ? 'rgba(220, 38, 38, 0.4)' : 'rgba(34, 197, 94, 0.4)')
                                                }"
                                                x-text="status.charAt(0).toUpperCase() + status.slice(1)">
                                            </span>

                                            <button x-show="status === 'pending'" @click="status = 'incomplete'"
                                                class="text-xs underline text-red-600">
                                                Mark Incomplete
                                            </button>

                                            <button x-show="status === 'incomplete'" @click="status = 'done'"
                                                class="text-xs underline text-green-600">
                                                Mark Done
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            @endfor
                        </div>
                    </div>

                    {{-- ── OFFERING PANEL ── --}}
                    <div x-show="activeTab === 'offering'" x-transition class="panel">
                        <h3 class="panel-title">Skills you can offer</h3>
                        <div class="mt-4 grid gap-4 md:grid-cols-2" x-data="{
                            skillOptions: {
                                Programming: ['Python', 'C', 'Java', 'JavaScript', 'PHP'],
                                Design: ['UI/UX', 'Figma', 'Illustration', 'Branding', 'Motion'],
                                Marketing: ['SEO', 'Content Marketing', 'Social Media', 'Email Marketing', 'Copywriting'],
                                Languages: ['English', 'Spanish', 'French', 'Arabic', 'German']
                            },
                            selectedCategory: 'Programming',
                            selectedSkill: 'Python'
                        }">
                            <div>
                                <label for="skill-category"
                                    class="mb-1 block text-sm font-medium"
                                    style="color:#9a8a6a;">
                                    Skill Category
                                </label>
                                <select
                                    id="skill-category"
                                    x-model="selectedCategory"
                                    @change="selectedSkill = skillOptions[selectedCategory][0]"
                                >
                                    <option>Programming</option>
                                    <option>Design</option>
                                    <option>Marketing</option>
                                    <option>Languages</option>
                                </select>
                            </div>

                            <div>
                                <label for="skill-name"
                                    class="mb-1 block text-sm font-medium"
                                    style="color:#9a8a6a;">
                                    Skill Name
                                </label>
                                <select id="skill-name" x-model="selectedSkill">
                                    <template x-for="skill in skillOptions[selectedCategory]" :key="skill">
                                        <option :value="skill" x-text="skill"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>