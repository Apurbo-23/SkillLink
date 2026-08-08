{{--
    Chat panel between the two matched users on this swap. Uses polling
    (a lightweight fetch every few seconds) rather than WebSockets, so it
    needs no extra server process to run - it appends new messages into
    the thread without a full page reload.

    Expects: $swapRequest
--}}
<div class="p-5 rounded-lg border mt-6" style="background-color: #121110; border-color: #D4AF37;">
    <h3 class="font-semibold mb-3" style="color: #D4AF37;">Chat</h3>

    <div id="chat-thread"
         data-poll-url="{{ route('messages.poll', $swapRequest) }}"
         data-store-url="{{ route('messages.store', $swapRequest) }}"
         data-current-user-id="{{ auth()->id() }}"
         data-last-id="{{ $swapRequest->messages->last()->id ?? 0 }}"
         class="space-y-3 mb-4 overflow-y-auto"
         style="max-height: 360px; padding-right: 0.25rem;">
        @forelse ($swapRequest->messages as $message)
            @include('swap-requests.partials.chat-message', ['message' => $message])
        @empty
            <p id="chat-empty-state" class="text-sm text-center py-4" style="color: #9a8a6a;">
                No messages yet. Say hello!
            </p>
        @endforelse
    </div>

    <form id="chat-form" class="flex gap-2 items-start" enctype="multipart/form-data">
        @csrf
        <div class="flex-1">
            <textarea name="body" rows="2" maxlength="2000" placeholder="Type a message..."
                class="w-full rounded border p-2" style="background-color: #0B0A09; color: #e8dfc8; border-color: #D4AF37;"></textarea>
            <div class="flex items-center justify-between mt-1">
                <label class="text-xs cursor-pointer" style="color:#9a8a6a;">
                    <input type="file" name="attachment" id="chat-attachment" class="hidden">
                    📎 <span id="chat-attachment-name">Attach a file</span>
                </label>
                <span id="chat-error" class="text-xs" style="color:#f5b7b1;"></span>
            </div>
        </div>
        <button type="submit" class="px-4 py-2 rounded font-semibold" style="background-color: #D4AF37; color: #0B0A09;">
            Send
        </button>
    </form>
</div>

<script>
(function () {
    const thread = document.getElementById('chat-thread');
    const form = document.getElementById('chat-form');
    const bodyInput = form.querySelector('textarea[name="body"]');
    const fileInput = document.getElementById('chat-attachment');
    const fileNameLabel = document.getElementById('chat-attachment-name');
    const errorLabel = document.getElementById('chat-error');
    const currentUserId = parseInt(thread.dataset.currentUserId, 10);
    const storeUrl = thread.dataset.storeUrl;
    const pollUrl = thread.dataset.pollUrl;
    let lastId = parseInt(thread.dataset.lastId, 10) || 0;
    const csrfToken = form.querySelector('input[name="_token"]').value;

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str ?? '';
        return div.innerHTML;
    }

    function renderMessage(message) {
        const isMine = message.sender_id === currentUserId;
        const wrapper = document.createElement('div');
        wrapper.dataset.messageId = message.id;
        wrapper.style.display = 'flex';
        wrapper.style.justifyContent = isMine ? 'flex-end' : 'flex-start';

        const bubble = document.createElement('div');
        bubble.style.maxWidth = '75%';
        bubble.style.padding = '0.5rem 0.75rem';
        bubble.style.borderRadius = '0.5rem';
        bubble.style.backgroundColor = isMine ? 'rgba(212,175,55,0.15)' : '#1a1814';
        bubble.style.border = '1px solid ' + (isMine ? '#D4AF37' : 'rgba(212,175,55,0.2)');

        let html = '<div style="font-size:0.7rem; color:#9a8a6a; margin-bottom:0.15rem;">'
            + escapeHtml(message.sender_name) + ' &middot; ' + escapeHtml(message.created_at) + '</div>';

        if (message.body) {
            html += '<div style="color:#e8dfc8; white-space:pre-wrap;">' + escapeHtml(message.body) + '</div>';
        }

        if (message.has_attachment) {
            html += '<a href="' + message.download_url + '" style="display:inline-block; margin-top:0.35rem; color:#D4AF37; font-size:0.85rem; text-decoration:underline;">'
                + '📎 ' + escapeHtml(message.file_name) + ' (' + escapeHtml(message.file_size) + ')</a>';
        }

        bubble.innerHTML = html;
        wrapper.appendChild(bubble);
        return wrapper;
    }

    function appendMessage(message) {
        const emptyState = document.getElementById('chat-empty-state');
        if (emptyState) emptyState.remove();

        thread.appendChild(renderMessage(message));
        thread.scrollTop = thread.scrollHeight;
        lastId = Math.max(lastId, message.id);
    }

    fileInput.addEventListener('change', function () {
        fileNameLabel.textContent = fileInput.files.length ? fileInput.files[0].name : 'Attach a file';
    });

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        errorLabel.textContent = '';

        if (!bodyInput.value.trim() && !fileInput.files.length) {
            errorLabel.textContent = 'Write a message or attach a file.';
            return;
        }

        const formData = new FormData();
        formData.append('body', bodyInput.value);
        if (fileInput.files.length) {
            formData.append('attachment', fileInput.files[0]);
        }

        fetch(storeUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: formData,
        })
            .then(function (response) {
                if (!response.ok) {
                    return response.json().then(function (data) {
                        throw new Error(data.message || 'Could not send message.');
                    });
                }
                return response.json();
            })
            .then(function (data) {
                appendMessage(data.message);
                bodyInput.value = '';
                fileInput.value = '';
                fileNameLabel.textContent = 'Attach a file';
            })
            .catch(function (err) {
                errorLabel.textContent = err.message;
            });
    });

    function poll() {
        fetch(pollUrl + '?after_id=' + lastId, { headers: { 'Accept': 'application/json' } })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                (data.messages || []).forEach(function (message) {
                    if (!thread.querySelector('[data-message-id="' + message.id + '"]')) {
                        appendMessage(message);
                    }
                });
            })
            .catch(function () { /* silent - will retry on the next tick */ });
    }

    thread.scrollTop = thread.scrollHeight;
    setInterval(poll, 3000);
})();
</script>
