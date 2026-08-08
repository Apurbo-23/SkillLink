<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\Message;
use App\Models\SwapRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    protected function makeSwapRequest(): SwapRequest
    {
        $requester = User::factory()->create(['credits' => 20]);
        $provider = User::factory()->create(['credits' => 20]);
        $listing = Listing::factory()->create(['user_id' => $provider->id]);

        $this->actingAs($requester)->post(route('swap-requests.store', $listing), [
            'message' => 'Hi, let’s swap!',
        ]);

        return SwapRequest::first();
    }

    public function test_either_matched_user_can_send_a_text_message(): void
    {
        $swapRequest = $this->makeSwapRequest();

        $response = $this->actingAs($swapRequest->requester)->postJson(
            route('messages.store', $swapRequest),
            ['body' => 'Sounds great, when are you free?']
        );

        $response->assertOk();
        $this->assertDatabaseHas('messages', [
            'swap_request_id' => $swapRequest->id,
            'sender_id' => $swapRequest->requester_id,
            'body' => 'Sounds great, when are you free?',
        ]);
    }

    public function test_a_user_outside_the_swap_cannot_send_a_message(): void
    {
        $swapRequest = $this->makeSwapRequest();
        $outsider = User::factory()->create();

        $response = $this->actingAs($outsider)->postJson(
            route('messages.store', $swapRequest),
            ['body' => 'Let me in!']
        );

        $response->assertForbidden();
    }

    public function test_a_message_needs_either_a_body_or_an_attachment(): void
    {
        $swapRequest = $this->makeSwapRequest();

        $response = $this->actingAs($swapRequest->provider)->postJson(
            route('messages.store', $swapRequest),
            []
        );

        $response->assertStatus(422);
    }

    public function test_a_user_can_send_a_file_attachment(): void
    {
        Storage::fake('local');
        $swapRequest = $this->makeSwapRequest();

        $file = UploadedFile::fake()->create('portfolio.pdf', 500, 'application/pdf');

        $response = $this->actingAs($swapRequest->provider)->postJson(
            route('messages.store', $swapRequest),
            ['attachment' => $file]
        );

        $response->assertOk();
        $message = Message::first();

        $this->assertTrue($message->hasAttachment());
        $this->assertEquals('portfolio.pdf', $message->file_name);
        Storage::disk('local')->assertExists($message->file_path);
    }

    public function test_only_matched_users_can_download_an_attachment(): void
    {
        Storage::fake('local');
        $swapRequest = $this->makeSwapRequest();
        $outsider = User::factory()->create();

        $file = UploadedFile::fake()->create('notes.txt', 10, 'text/plain');
        $this->actingAs($swapRequest->requester)->postJson(
            route('messages.store', $swapRequest),
            ['attachment' => $file]
        );
        $message = Message::first();

        $this->actingAs($swapRequest->provider)
            ->get(route('messages.download', $message))
            ->assertOk();

        $this->actingAs($outsider)
            ->get(route('messages.download', $message))
            ->assertForbidden();
    }

    public function test_polling_only_returns_messages_after_the_given_id(): void
    {
        $swapRequest = $this->makeSwapRequest();

        $this->actingAs($swapRequest->requester)->postJson(
            route('messages.store', $swapRequest), ['body' => 'first']
        );
        $this->actingAs($swapRequest->provider)->postJson(
            route('messages.store', $swapRequest), ['body' => 'second']
        );

        $firstId = Message::where('body', 'first')->first()->id;

        $response = $this->actingAs($swapRequest->requester)->getJson(
            route('messages.poll', $swapRequest).'?after_id='.$firstId
        );

        $response->assertOk();
        $response->assertJsonCount(1, 'messages');
        $response->assertJsonPath('messages.0.body', 'second');
    }
}
