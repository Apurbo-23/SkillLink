@php
    $isMine = $message->sender_id === auth()->id();
@endphp
<div data-message-id="{{ $message->id }}" style="display:flex; justify-content: {{ $isMine ? 'flex-end' : 'flex-start' }};">
    <div style="max-width:75%; padding:0.5rem 0.75rem; border-radius:0.5rem;
        background-color: {{ $isMine ? 'rgba(212,175,55,0.15)' : '#1a1814' }};
        border: 1px solid {{ $isMine ? '#D4AF37' : 'rgba(212,175,55,0.2)' }};">
        <div style="font-size:0.7rem; color:#9a8a6a; margin-bottom:0.15rem;">
            {{ $message->sender->name }} &middot; {{ $message->created_at->format('M j, g:i A') }}
        </div>

        @if ($message->body)
            <div style="color:#e8dfc8; white-space:pre-wrap;">{{ $message->body }}</div>
        @endif

        @if ($message->hasAttachment())
            <a href="{{ route('messages.download', $message) }}"
               style="display:inline-block; margin-top:0.35rem; color:#D4AF37; font-size:0.85rem; text-decoration:underline;">
                📎 {{ $message->file_name }} ({{ $message->fileSizeForHumans() }})
            </a>
        @endif
    </div>
</div>
