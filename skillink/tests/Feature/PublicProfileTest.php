<?php

namespace Tests\Feature;

use App\Models\Endorsement;
use App\Models\Listing;
use App\Models\PortfolioItem;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_new_user_automatically_gets_a_unique_profile_slug(): void
    {
        $user = User::factory()->create(['name' => 'Ada Lovelace']);

        $this->assertNotEmpty($user->profile_slug);
        $this->assertStringStartsWith('ada-lovelace-', $user->profile_slug);
    }

    public function test_anyone_can_view_a_public_profile_without_logging_in(): void
    {
        $user = User::factory()->create(['name' => 'Grace Hopper']);

        $response = $this->get('/u/'.$user->profile_slug);

        $response->assertOk();
        $response->assertSee('Grace Hopper');
    }

    public function test_an_unknown_slug_returns_a_404(): void
    {
        $response = $this->get('/u/does-not-exist');

        $response->assertNotFound();
    }

    public function test_the_public_profile_shows_active_listings_portfolio_ratings_and_endorsements(): void
    {
        $user = User::factory()->create();
        $rater = User::factory()->create();

        Listing::factory()->create([
            'user_id' => $user->id,
            'skill_offered' => 'Guitar Lessons',
            'status' => 'active',
        ]);
        Listing::factory()->create([
            'user_id' => $user->id,
            'skill_offered' => 'Retired Skill',
            'status' => 'paused',
        ]);

        PortfolioItem::create([
            'user_id' => $user->id,
            'title' => 'My Best Work',
        ]);

        Rating::factory()->create([
            'rater_id' => $rater->id,
            'rated_user_id' => $user->id,
            'score' => 5,
            'review' => 'Fantastic teacher!',
        ]);

        Endorsement::create([
            'endorser_id' => $rater->id,
            'endorsed_user_id' => $user->id,
            'skill' => 'Guitar',
        ]);

        $response = $this->get('/u/'.$user->profile_slug);

        $response->assertOk();
        $response->assertSee('Guitar Lessons');
        $response->assertDontSee('Retired Skill');
        $response->assertSee('My Best Work');
        $response->assertSee('Fantastic teacher!');
        $response->assertSee('Guitar');
        $response->assertSee('5 / 5');
    }

    public function test_average_rating_helper_returns_null_with_no_ratings(): void
    {
        $user = User::factory()->create();

        $this->assertNull($user->averageRating());
    }

    public function test_average_rating_helper_averages_multiple_scores(): void
    {
        $user = User::factory()->create();

        Rating::factory()->create(['rated_user_id' => $user->id, 'score' => 5]);
        Rating::factory()->create(['rated_user_id' => $user->id, 'score' => 3]);

        $this->assertEquals(4.0, $user->averageRating());
    }
}
