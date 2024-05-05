<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\LieuVote;

use App\Models\Quartier;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LieuVoteTest extends TestCase
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
    public function it_gets_lieu_votes_list()
    {
        $lieuVotes = LieuVote::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.lieu-votes.index'));

        $response->assertOk()->assertSee($lieuVotes[0]->code);
    }

    /**
     * @test
     */
    public function it_stores_the_lieu_vote()
    {
        $data = LieuVote::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.lieu-votes.store'), $data);

        $this->assertDatabaseHas('lieu_votes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_lieu_vote()
    {
        $lieuVote = LieuVote::factory()->create();

        $quartier = Quartier::factory()->create();

        $data = [
            'code' => $this->faker->unique->text(255),
            'libel' => $this->faker->text(255),
            'nbrinscrit' => $this->faker->randomNumber(0),
            'objectif' => $this->faker->randomNumber(0),
            'seuil' => $this->faker->randomNumber(0),
            'quartier_id' => $quartier->id,
        ];

        $response = $this->putJson(
            route('api.lieu-votes.update', $lieuVote),
            $data
        );

        $data['id'] = $lieuVote->id;

        $this->assertDatabaseHas('lieu_votes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_lieu_vote()
    {
        $lieuVote = LieuVote::factory()->create();

        $response = $this->deleteJson(
            route('api.lieu-votes.destroy', $lieuVote)
        );

        $this->assertDeleted($lieuVote);

        $response->assertNoContent();
    }
}
