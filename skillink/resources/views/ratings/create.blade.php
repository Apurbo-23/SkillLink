<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #D4AF37;">Rate Your Swap Partner</h2>
    </x-slot>

    <style>
        body,
        .bg-gray-100 { background-color: #0B0A09 !important; }

        .bg-white {
            background-color: #121110 !important;
            border: 1px solid rgba(212, 175, 55, 0.15);
        }

        .star-rating {
            display: flex;
            gap: 0.75rem;
            font-size: 2rem;
        }

        .star {
            cursor: pointer;
            color: #666;
            transition: color 0.2s;
            user-select: none;
        }

        .star:hover,
        .star.active {
            color: #D4AF37;
        }

        .rating-info {
            background-color: #1a1814;
            border: 1px solid rgba(212, 175, 55, 0.25);
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
    </style>

    <div class="py-8 max-w-xl mx-auto px-4" style="background-color: #0B0A09; min-height: 100vh;">
        @if (session('success'))
            <div class="mb-4 p-4 rounded" style="background-color:#1a1814; color:#D4AF37; border:1px solid rgba(212,175,55,0.25);">
                {{ session('success') }}
            </div>
        @endif

        <!-- Swap Details -->
        <div class="p-6 rounded-lg border mb-6" style="background-color: #121110; border-color: #D4AF37; color: #e8dfc8;">
            <div class="mb-4">
                <span style="color:#9a8a6a;">Swap:</span>
                <p class="font-semibold mt-1" style="color:#D4AF37;">
                    {{ $swapRequest->listing->skill_offered }} ↔ {{ $swapRequest->listing->skill_wanted }}
                </p>
            </div>
            <div class="mb-4">
                <span style="color:#9a8a6a;">Your Partner:</span>
                <p class="font-semibold mt-1">{{ $swapRequest->requester_id === auth()->id() ? $swapRequest->provider->name : $swapRequest->requester->name }}</p>
            </div>
            <div>
                <span style="color:#9a8a6a;">Status:</span>
                <p class="font-semibold mt-1" style="color:#D4AF37;">Completed ✓</p>
            </div>
        </div>

        <!-- Rating Form -->
        <div class="p-6 rounded-lg border" style="background-color: #121110; border-color: #D4AF37; color: #e8dfc8;">
            <div class="rating-info">
                <p style="color:#9a8a6a; font-size: 0.875rem; margin-bottom: 0.5rem;">
                    Share your experience with your swap partner. Your honest feedback helps build trust in the SkillLink community.
                </p>
            </div>

            <form method="POST" action="{{ route('ratings.store', $swapRequest) }}" id="ratingForm">
                @csrf

                <!-- Star Rating -->
                <div class="mb-6">
                    <label style="display: block; color: #9a8a6a; font-size: 0.875rem; margin-bottom: 1rem;">
                        Rating <span style="color: #f5b7b1;">*</span>
                    </label>
                    <div class="star-rating" id="starRating">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star" data-value="{{ $i }}" data-index="{{ $i - 1 }}">★</span>
                        @endfor
                    </div>
                    <input type="hidden" id="scoreInput" name="score" value="0">
                    @error('score')
                        <div style="color: #f5b7b1; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Review Text -->
                <div class="mb-6">
                    <label for="review" style="display: block; color: #9a8a6a; font-size: 0.875rem; margin-bottom: 0.5rem;">
                        Review (Optional)
                    </label>
                    <textarea 
                        id="review"
                        name="review" 
                        rows="4" 
                        placeholder="Share your thoughts about the swap (max 500 characters)..."
                        style="background-color: #0B0A09; border: 1px solid rgba(212, 175, 55, 0.25); color: #e8dfc8; border-radius: 0.375rem; width: 100%; padding: 0.75rem; font-family: inherit; resize: vertical;"
                    ></textarea>
                    <div style="color: #9a8a6a; font-size: 0.75rem; margin-top: 0.5rem;">
                        <span id="charCount">0</span> / 500 characters
                    </div>
                    @error('review')
                        <div style="color: #f5b7b1; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button 
                        type="submit" 
                        class="px-4 py-2 rounded font-semibold transition ease-in-out"
                        style="background-color: #D4AF37; color: #0B0A09; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#e8c13f'"
                        onmouseout="this.style.backgroundColor='#D4AF37'"
                    >
                        ⭐ Submit Rating
                    </button>
                    <a 
                        href="{{ route('swap-requests.show', $swapRequest) }}"
                        class="px-4 py-2 rounded font-semibold"
                        style="background-color: #1a1814; color: #9a8a6a; border: 1px solid rgba(212, 175, 55, 0.3); text-decoration: none; display: inline-block;"
                    >
                        Skip
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const stars = document.querySelectorAll('.star');
        const scoreInput = document.getElementById('scoreInput');
        const reviewInput = document.getElementById('review');
        const charCount = document.getElementById('charCount');

        // Star rating functionality
        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                scoreInput.value = value;
                
                // Update star display
                stars.forEach(s => {
                    const starValue = s.getAttribute('data-value');
                    if (starValue <= value) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });

            // Hover effect
            star.addEventListener('mouseover', () => {
                const value = star.getAttribute('data-value');
                stars.forEach(s => {
                    const starValue = s.getAttribute('data-value');
                    if (starValue <= value) {
                        s.style.color = '#D4AF37';
                    } else {
                        s.style.color = '#666';
                    }
                });
            });
        });

        document.getElementById('starRating').addEventListener('mouseout', () => {
            stars.forEach(star => {
                if (star.classList.contains('active')) {
                    star.style.color = '#D4AF37';
                } else {
                    star.style.color = '#666';
                }
            });
        });

        // Character counter for review
        reviewInput.addEventListener('input', () => {
            charCount.textContent = reviewInput.value.length;
        });

        // Form submission validation
        document.getElementById('ratingForm').addEventListener('submit', (e) => {
            if (scoreInput.value === '0' || scoreInput.value === '') {
                e.preventDefault();
                alert('Please select a rating before submitting.');
            }
        });
    </script>
</x-app-layout>
