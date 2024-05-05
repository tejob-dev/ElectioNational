<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Commune;
use App\Models\LieuVote;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LieuVoteCommunesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_lieu_vote_communes()
    {
        $lieuVote = LieuVote::factory()->create();
        $commune = Commune::factory()->create();

        $lieuVote->communes()->attach($commune);

        $response = $this->getJson(
            route('api.lieu-votes.communes.index', $lieuVote)
        );

        $response->assertOk()->assertSee($commune->libel);
    }

    /**
     * @test
     */
    public function it_can_attach_communes_to_lieu_vote()
    {
        $lieuVote = LieuVote::factory()->create();
        $commune = Commune::factory()->create();

        $response = $this->postJson(
            route('api.lieu-votes.communes.store', [$lieuVote, $commune])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $lieuVote
                ->communes()
                ->where('communes.id', $commune->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_communes_from_lieu_vote()
    {
        $lieuVote = LieuVote::factory()->create();
        $commune = Commune::factory()->create();

        $response = $this->deleteJson(
            route('api.lieu-votes.communes.store', [$lieuVote, $commune])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $lieuVote
                ->communes()
                ->where('communes.id', $commune->id)
                ->exists()
        );
    }
}
