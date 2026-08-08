<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\SwapRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    /**
     * A short list of file types allowed as chat attachments. Kept
     * deliberately narrow - no scripts/executables - since uploads are
     * stored under storage/app where the app itself can read them back.
     */
    protected const ALLOWED_EXTENSIONS = 'jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip';

    protected function authorizeParty(Request $request, SwapRequest $swapRequest): void
    {
        abort_unless(
            in_array($request->user()->id, [$swapRequest->requester_id, $swapRequest->provider_id]),
            403,
            'You are not part of this swap.'
        );
    }

    /**
     * Post a new chat message, with an optional file attachment.
     */
    public function store(Request $request, SwapRequest $swapRequest)
    {
        $this->authorizeParty($request, $swapRequest);

        $validated = $request->validate([
            'body' => 'required_without:attachment|nullable|string|max:2000',
            'attachment' => 'required_without:body|nullable|file|max:10240|mimes:'.self::ALLOWED_EXTENSIONS,
        ]);

        $data = [
            'swap_request_id' => $swapRequest->id,
            'sender_id' => $request->user()->id,
            'body' => $validated['body'] ?? null,
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store("chat-attachments/{$swapRequest->id}", 'local');

            $data['file_path'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['file_mime'] = $file->getClientMimeType();
        }

        $message = Message::create($data)->load('sender');

        if ($request->wantsJson()) {
            return response()->json(['message' => $this->formatMessage($message)]);
        }

        return back();
    }

    /**
     * Poll for messages newer than a given id, for the chat panel to
     * refresh itself without a full page reload.
     */
    public function poll(Request $request, SwapRequest $swapRequest)
    {
        $this->authorizeParty($request, $swapRequest);

        $afterId = (int) $request->query('after_id', 0);

        $messages = $swapRequest->messages()
            ->where('id', '>', $afterId)
            ->with('sender')
            ->get();

        return response()->json([
            'messages' => $messages->map(fn (Message $message) => $this->formatMessage($message)),
        ]);
    }

    /**
     * Download an attachment - only the two people on this swap can fetch it.
     */
    public function download(Request $request, Message $message)
    {
        $this->authorizeParty($request, $message->swapRequest);

        abort_unless($message->hasAttachment(), 404);
        abort_unless(Storage::disk('local')->exists($message->file_path), 404);

        return Storage::disk('local')->download($message->file_path, $message->file_name);
    }

    protected function formatMessage(Message $message): array
    {
        return [
            'id' => $message->id,
            'sender_id' => $message->sender_id,
            'sender_name' => $message->sender->name,
            'body' => $message->body,
            'has_attachment' => $message->hasAttachment(),
            'file_name' => $message->file_name,
            'file_size' => $message->fileSizeForHumans(),
            'download_url' => $message->hasAttachment() ? route('messages.download', $message) : null,
            'created_at' => $message->created_at->format('M j, g:i A'),
        ];
    }
}
