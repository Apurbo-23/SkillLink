{{--
    Swap progress tracker. Shows the 4-stage flow (Proposed -> Accepted ->
    In Progress -> Completed) with the current stage highlighted. Same
    view for both the requester and the provider - progress is visible
    to both parties, not just whoever's turn it is to act.

    Expects: $swapRequest
--}}
@if ($swapRequest->isSidelined())
    <div class="mb-6 p-4 rounded-lg border" style="background-color: #1a1814; border-color: rgba(245,183,177,0.4);">
        <span style="color:#f5b7b1; font-weight:600;">{{ ucfirst($swapRequest->status) }}</span>
        <span style="color:#9a8a6a;">
            &mdash; this swap did not go through and is no longer moving through the stages below.
        </span>
    </div>
@else
    @php
        $stages = \App\Models\SwapRequest::STAGES;
        $currentIndex = $swapRequest->stageIndex();
    @endphp
    <div class="mb-6 p-5 rounded-lg border" style="background-color: #121110; border-color: #D4AF37;">
        <div class="flex items-center justify-between">
            @foreach ($stages as $status => $label)
                @php
                    $index = $loop->index;
                    $isDone = $currentIndex !== null && $index < $currentIndex;
                    $isCurrent = $currentIndex !== null && $index === $currentIndex;
                @endphp
                <div class="flex-1 flex flex-col items-center text-center" style="position: relative;">
                    <div style="
                        width: 2rem; height: 2rem; border-radius: 9999px;
                        display: flex; align-items: center; justify-content: center;
                        font-weight: 700; font-size: 0.85rem;
                        background-color: {{ $isDone || $isCurrent ? '#D4AF37' : '#0B0A09' }};
                        color: {{ $isDone || $isCurrent ? '#0B0A09' : '#9a8a6a' }};
                        border: 2px solid {{ $isDone || $isCurrent ? '#D4AF37' : 'rgba(212,175,55,0.3)' }};
                    ">
                        @if ($isDone)
                            &#10003;
                        @else
                            {{ $index + 1 }}
                        @endif
                    </div>
                    <span class="mt-2 text-xs" style="color: {{ $isCurrent ? '#D4AF37' : '#9a8a6a' }}; font-weight: {{ $isCurrent ? '700' : '400' }};">
                        {{ $label }}
                    </span>
                </div>
                @if (!$loop->last)
                    <div style="flex: 1.5; height: 2px; margin: 0 0.25rem; margin-bottom: 1.4rem; background-color: {{ $isDone ? '#D4AF37' : 'rgba(212,175,55,0.2)' }};"></div>
                @endif
            @endforeach
        </div>
    </div>
@endif
