<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #D4AF37;">
            {{ __('Search Skills') }}
        </h2>
    </x-slot>

    <style>
        body,
        .bg-gray-100 { background-color: #0B0A09 !important; }

        .bg-white {
            background-color: #121110 !important;
            border: 1px solid rgba(212, 175, 55, 0.15);
        }

        .text-gray-900 { color: #e8dfc8 !important; }
        .text-gray-700,
        .text-sm.font-medium { color: #9a8a6a !important; }

        select,
        input[type="text"] {
            background-color: #1a1814 !important;
            border: 1.5px solid rgba(212, 175, 55, 0.25) !important;
            color: #e8dfc8 !important;
            border-radius: 0.375rem !important;
            padding: 0.4rem 0.6rem !important;
            width: 100% !important;
        }

        select:focus, input:focus {
            border-color: #D4AF37 !important;
            box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.18) !important;
        }

        select option {
            background-color: #1a1814;
            color: #e8dfc8;
        }

        header.bg-white, nav.bg-white {
            background-color: #0f0e0c !important;
            border-bottom: 1px solid rgba(212, 175, 55, 0.12) !important;
        }

        .search-panel {
            background-color: #181612;
            border: 1px solid rgba(212, 175, 55, 0.15);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .search-title {
            font-size: 1rem;
            font-weight: 600;
            color: #D4AF37;
            margin-bottom: 1rem;
        }

        .user-card {
            background-color: #0f0e0c;
            border: 1px solid rgba(212, 175, 55, 0.12);
            border-radius: 0.5rem;
            padding: 1.5rem;
            transition: all 0.2s ease;
        }

        .user-card:hover {
            border-color: rgba(212, 175, 55, 0.35);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.1);
        }

        .user-name {
            font-size: 1rem;
            font-weight: 600;
            color: #e8dfc8;
            margin-bottom: 0.5rem;
        }

        .skill-badge {
            display: inline-block;
            background-color: rgba(212, 175, 55, 0.15);
            border: 1px solid rgba(212, 175, 55, 0.3);
            color: #D4AF37;
            padding: 0.35rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .user-meta {
            font-size: 0.9rem;
            color: #9a8a6a;
            margin-bottom: 1rem;
        }

        .action-button {
            display: inline-block;
            background-color: #D4AF37;
            color: #0B0A09;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .action-button:hover {
            background-color: #e8dfc8;
        }

        .no-results {
            text-align: center;
            padding: 2rem 1rem;
            color: #9a8a6a;
        }

        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .btn-search {
            background-color: #D4AF37;
            color: #0B0A09;
            padding: 0.65rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
        }

        .btn-search:hover {
            background-color: #e8dfc8;
        }

        .shadow-sm { box-shadow: 0 1px 8px rgba(0,0,0,0.5) !important; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background-color:#121110; border:1px solid rgba(212,175,55,0.15);">
                <div class="p-6">
                    <!-- Search Filter Panel -->
                    <div class="search-panel">
                        <h3 class="search-title">Filter by Skill Offering</h3>
                        
                        <form method="GET" action="{{ route('search-skills') }}" class="grid gap-4 md:grid-cols-2 items-end">
                            <div>
                                <label for="category" class="mb-1 block text-sm font-medium" style="color:#9a8a6a;">
                                    Skill Category
                                </label>
                                <select id="category" name="category">
                                    <option value="">-- All Categories --</option>
                                    <option value="Programming" @selected($selectedCategory === 'Programming')>Programming</option>
                                    <option value="Design" @selected($selectedCategory === 'Design')>Design</option>
                                    <option value="Marketing" @selected($selectedCategory === 'Marketing')>Marketing</option>
                                    <option value="Languages" @selected($selectedCategory === 'Languages')>Languages</option>
                                </select>
                            </div>

                            <div>
                                <label for="skill" class="mb-1 block text-sm font-medium" style="color:#9a8a6a;">
                                    Skill Name
                                </label>
                                <input 
                                    type="text" 
                                    id="skill" 
                                    name="skill" 
                                    value="{{ $selectedSkill }}"
                                    placeholder="Type a skill name..."
                                    list="available-skills"
                                    style="background-color:#1a1814 !important; border:1.5px solid rgba(212,175,55,0.25) !important; color:#e8dfc8 !important; border-radius:0.375rem !important; padding:0.4rem 0.6rem !important; width:100% !important;"
                                />
                                <datalist id="available-skills">
                                    <option value="Python">
                                    <option value="JavaScript">
                                    <option value="Java">
                                    <option value="C">
                                    <option value="PHP">
                                    <option value="UI/UX">
                                    <option value="Figma">
                                    <option value="Illustration">
                                    <option value="Branding">
                                    <option value="Motion">
                                    <option value="SEO">
                                    <option value="Content Marketing">
                                    <option value="Social Media">
                                    <option value="Email Marketing">
                                    <option value="Copywriting">
                                    <option value="English">
                                    <option value="Spanish">
                                    <option value="French">
                                    <option value="Arabic">
                                    <option value="German">
                                </datalist>
                            </div>

                            <div class="md:col-span-2">
                                <button type="submit" class="btn-search w-full h-9">
                                    Search
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Results Section -->
                    @if ($selectedCategory || $selectedSkill)
                        <div>
                            @if ($selectedSkill)
                                <h3 class="search-title" style="margin-bottom: 1.5rem;">
                                    Users offering <span style="color: #D4AF37;">"{{ $selectedSkill }}"</span>
                                </h3>
                            @endif

                            @if ($results->count() > 0)
                                <div class="results-grid">
                                    @foreach ($results as $user)
                                        <div class="user-card">
                                            <div class="user-name">{{ $user->name }}</div>
                                            
                                            <div class="skill-badge">
                                                {{ $selectedSkill }}
                                            </div>

                                            <div class="user-meta">
                                                @if ($user->averageRating())
                                                    ⭐ {{ $user->averageRating() }}/5.0
                                                @else
                                                    <span style="color: #6b7280;">No ratings yet</span>
                                                @endif
                                            </div>

                                            <div class="flex gap-2">
                                                <a href="{{ route('profile.public', $user->profile_slug) }}" class="action-button flex-1 text-center">
                                                    View Profile
                                                </a>
                                                <a href="{{ route('swap-requests.create', ['listing' => 0]) }}" class="action-button flex-1 text-center">
                                                    Connect
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Pagination -->
                                @if ($results->hasPages())
                                    <div class="mt-6">
                                        {{ $results->links() }}
                                    </div>
                                @endif
                            @else
                                <div class="no-results">
                                    <p style="font-size: 1rem;">No users found offering "{{ $selectedSkill }}"</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
