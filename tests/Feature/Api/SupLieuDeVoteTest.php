<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SupLieuDeVote;

use App\Models\LieuVote;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupLieuDeVoteTest extends TestCase
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
    public function it_gets_sup_lieu_de_votes_list()
    {
        $supLieuDeVotes = SupLieuDeVote::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.sup-lieu-de-votes.index'));

        $response->assertOk()->assertSee($supLieuDeVotes[0]->nom);
    }

    /**
     * @test
     */
    public function it_stores_the_sup_lieu_de_vote()
    {
        $data = SupLieuDeVote::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.sup-lieu-de-votes.store'),
            $data
        );

        $this->assertDatabaseHas('sup_lieu_de_votes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_sup_lieu_de_vote()
    {
        $supLieuDeVote = SupLieuDeVote::factory()->create();

        $lieuVote = LieuVote::factory()->create();

        $data = [
            'nom' => $this->faker->text(255),
            'prenom' => $this->faker->text(255),
            'telephone' => $this->faker->text(255),
            'lieu_vote_id' => $lieuVote->id,
        ];

        $response = $this->putJson(
            route('api.sup-lieu-de-votes.update', $supLieuDeVote),
            $data
        );

        $data['id'] = $supLieuDeVote->id;

        $this->assertDatabaseHas('sup_lieu_de_votes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_sup_lieu_de_vote()
    {
        $supLieuDeVote = SupLieuDeVote::factory()->create();

        $response = $this->deleteJson(
            route('api.sup-lieu-de-votes.destroy', $supLieuDeVote)
        );

        $this->assertDeleted($supLieuDeVote);

        $response->assertNoContent();
    }
}
