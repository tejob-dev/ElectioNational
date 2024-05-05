<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\LieuVote;
use App\Models\SupLieuDeVote;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LieuVoteSupLieuDeVotesTest extends TestCase
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
    public function it_gets_lieu_vote_sup_lieu_de_votes()
    {
        $lieuVote = LieuVote::factory()->create();
        $supLieuDeVotes = SupLieuDeVote::factory()
            ->count(2)
            ->create([
                'lieu_vote_id' => $lieuVote->id,
            ]);

        $response = $this->getJson(
            route('api.lieu-votes.sup-lieu-de-votes.index', $lieuVote)
        );

        $response->assertOk()->assertSee($supLieuDeVotes[0]->nom);
    }

    /**
     * @test
     */
    public function it_stores_the_lieu_vote_sup_lieu_de_votes()
    {
        $lieuVote = LieuVote::factory()->create();
        $data = SupLieuDeVote::factory()
            ->make([
                'lieu_vote_id' => $lieuVote->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.lieu-votes.sup-lieu-de-votes.store', $lieuVote),
            $data
        );

        $this->assertDatabaseHas('sup_lieu_de_votes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $supLieuDeVote = SupLieuDeVote::latest('id')->first();

        $this->assertEquals($lieuVote->id, $supLieuDeVote->lieu_vote_id);
    }
}
