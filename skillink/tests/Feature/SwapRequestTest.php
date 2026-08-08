<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\SwapRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SwapRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_send_a_swap_request_and_credits_are_held(): void
    {
        $requester = User::factory()->create(['credits' => 20]);
        $provider = User::factory()->create(['credits' => 20]);
        $listing = Listing::factory()->create(['user_id' => $provider->id]);

        $response = $this->actingAs($requester)->post(route('swap-requests.store', $listing), [
            'message' => 'Hi, I would love to swap skills with you!',
        ]);

        $response->assertRedirect(route('swap-requests.index'));

        $this->assertDatabaseHas('swap_requests', [
            'listing_id' => $listing->id,
            'requester_id' => $requester->id,
            'provider_id' => $provider->id,
            'status' => 'pending',
        ]);

        $cost = config('skilllink.swap_request_cost');
        $this->assertEquals(20 - $cost, $requester->fresh()->credits);
    }

    public function test_user_cannot_request_a_swap_on_their_own_listing(): void
    {
        $user = User::factory()->create();
        $listing = Listing::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post(route('swap-requests.store', $listing), [
            'message' => 'Swap with myself?',
        ]);

        $response->assertForbidden();
    }

    public function test_swap_request_fails_without_enough_credits(): void
    {
        $requester = User::factory()->create(['credits' => 0]);
        $provider = User::factory()->create();
        $listing = Listing::factory()->create(['user_id' => $provider->id]);

        $response = $this->actingAs($requester)->post(route('swap-requests.store', $listing), [
            'message' => 'I would love to swap!',
        ]);

        $response->assertSessionHasErrors('message');
        $this->assertDatabaseMissing('swap_requests', ['listing_id' => $listing->id]);
    }

    public function test_rejecting_a_request_refunds_the_requesters_credits(): void
    {
        $requester = User::factory()->create(['credits' => 20]);
        $provider = User::factory()->create();
        $listing = Listing::factory()->create(['user_id' => $provider->id]);

        $this->actingAs($requester)->post(route('swap-requests.store', $listing), [
            'message' => 'Let’s swap!',
        ]);

        $swapRequest = SwapRequest::first();

        $this->actingAs($provider)->patch(route('swap-requests.reject', $swapRequest));

        $this->assertEquals(20, $requester->fresh()->credits);
        $this->assertEquals('rejected', $swapRequest->fresh()->status);
    }

    public function test_completing_an_in_progress_swap_pays_the_provider(): void
    {
        $requester = User::factory()->create(['credits' => 20]);
        $provider = User::factory()->create(['credits' => 20]);
        $listing = Listing::factory()->create(['user_id' => $provider->id]);

        $this->actingAs($requester)->post(route('swap-requests.store', $listing), [
            'message' => 'Let’s swap!',
        ]);

        $swapRequest = SwapRequest::first();
        $cost = $swapRequest->credits_amount;

        $this->actingAs($provider)->patch(route('swap-requests.accept', $swapRequest));
        $this->actingAs($provider)->patch(route('swap-requests.start', $swapRequest));
        $this->actingAs($provider)->patch(route('swap-requests.complete', $swapRequest));

        $this->assertEquals('completed', $swapRequest->fresh()->status);
        $this->assertEquals(20 + $cost, $provider->fresh()->credits);
        $this->assertEquals(20 - $cost, $requester->fresh()->credits);
    }

    public function test_swap_moves_through_all_four_stages_in_order(): void
    {
        $requester = User::factory()->create(['credits' => 20]);;
        $provider = User::factory()->create(['credits' => 20]);
        $listing = Listing::factory()->create(['user_id' => $provider->id]);

        $this->actingAs($requester)->post(route('swap-requests.store', $listing), [
            'message' => 'Let’s swap!',
        ]);
        $swapRequest = SwapRequest::first();

        $this->assertEquals('pending', $swapRequest->fresh()->status);
        $this->assertEquals(0, $swapRequest->fresh()->stageIndex());

        $this->actingAs($provider)->patch(route('swap-requests.accept', $swapRequest));
        $this->assertEquals('accepted', $swapRequest->fresh()->status);
        $this->assertEquals(1, $swapRequest->fresh()->stageIndex());

        $this->actingAs($requester)->patch(route('swap-requests.start', $swapRequest));
        $this->assertEquals('in_progress', $swapRequest->fresh()->status);
        $this->assertEquals(2, $swapRequest->fresh()->stageIndex());

        $this->actingAs($provider)->patch(route('swap-requests.complete', $swapRequest));
        $this->assertEquals('completed', $swapRequest->fresh()->status);
        $this->assertEquals(3, $swapRequest->fresh()->stageIndex());
    }

    public function test_cannot_complete_a_swap_that_has_not_started(): void
    {
        $requester = User::factory()->create(['credits' => 20]);
        $provider = User::factory()->create(['credits' => 20]);
        $listing = Listing::factory()->create(['user_id' => $provider->id]);

        $this->actingAs($requester)->post(route('swap-requests.store', $listing), [
            'message' => 'Let’s swap!',
        ]);
        $swapRequest = SwapRequest::first();

        $this->actingAs($provider)->patch(route('swap-requests.accept', $swapRequest));

        // Still just "accepted" - hasn't been started yet.
        $response = $this->actingAs($provider)->patch(route('swap-requests.complete', $swapRequest));

        $response->assertStatus(400);
        $this->assertEquals('accepted', $swapRequest->fresh()->status);
    }

    public function test_only_the_requester_or_provider_can_start_a_swap(): void
    {
        $requester = User::factory()->create(['credits' => 20]);
        $provider = User::factory()->create(['credits' => 20]);
        $outsider = User::factory()->create();
        $listing = Listing::factory()->create(['user_id' => $provider->id]);

        $this->actingAs($requester)->post(route('swap-requests.store', $listing), [
            'message' => 'Let’s swap!',
        ]);
        $swapRequest = SwapRequest::first();
        $this->actingAs($provider)->patch(route('swap-requests.accept', $swapRequest));

        $response = $this->actingAs($outsider)->patch(route('swap-requests.start', $swapRequest));

        $response->assertForbidden();
        $this->assertEquals('accepted', $swapRequest->fresh()->status);
    }
}
