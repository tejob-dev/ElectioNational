<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Commune;
use App\Models\LieuVote;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommuneLieuVotesTest extends TestCase
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
    public function it_gets_commune_lieu_votes()
    {
        $commune = Commune::factory()->create();
        $lieuVote = LieuVote::factory()->create();

        $commune->lieuVotes()->attach($lieuVote);

        $response = $this->getJson(
            route('api.communes.lieu-votes.index', $commune)
        );

        $response->assertOk()->assertSee($lieuVote->code);
    }

    /**
     * @test
     */
    public function it_can_attach_lieu_votes_to_commune()
    {
        $commune = Commune::factory()->create();
        $lieuVote = LieuVote::factory()->create();

        $response = $this->postJson(
            route('api.communes.lieu-votes.store', [$commune, $lieuVote])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $commune
                ->lieuVotes()
                ->where('lieu_votes.id', $lieuVote->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_lieu_votes_from_commune()
    {
        $commune = Commune::factory()->create();
        $lieuVote = LieuVote::factory()->create();

        $response = $this->deleteJson(
            route('api.communes.lieu-votes.store', [$commune, $lieuVote])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $commune
                ->lieuVotes()
                ->where('lieu_votes.id', $lieuVote->id)
                ->exists()
        );
    }
}
