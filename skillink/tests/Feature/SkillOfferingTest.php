<?php

namespace Tests\Feature;

use App\Models\SkillOffering;
use App\Models\SkillOfferingAttachment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SkillOfferingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_an_entire_skill_offering_and_its_samples(): void
    {
        $user = User::factory()->create();

        $offering = SkillOffering::create([
            'user_id' => $user->id,
            'category' => 'Programming',
            'skill_name' => 'PHP',
        ]);

        SkillOfferingAttachment::create([
            'skill_offering_id' => $offering->id,
            'type' => 'link',
            'url' => 'https://example.com/sample',
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('skill-offerings.destroy', $offering));

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseMissing('skill_offerings', ['id' => $offering->id]);
        $this->assertDatabaseMissing('skill_offering_attachments', ['skill_offering_id' => $offering->id]);
    }
}
