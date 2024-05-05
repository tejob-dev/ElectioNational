<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\LieuVote;
use App\Models\AgentTerrain;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LieuVoteAgentTerrainsTest extends TestCase
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
    public function it_gets_lieu_vote_agent_terrains()
    {
        $lieuVote = LieuVote::factory()->create();
        $agentTerrains = AgentTerrain::factory()
            ->count(2)
            ->create([
                'lieu_vote_id' => $lieuVote->id,
            ]);

        $response = $this->getJson(
            route('api.lieu-votes.agent-terrains.index', $lieuVote)
        );

        $response->assertOk()->assertSee($agentTerrains[0]->nom);
    }

    /**
     * @test
     */
    public function it_stores_the_lieu_vote_agent_terrains()
    {
        $lieuVote = LieuVote::factory()->create();
        $data = AgentTerrain::factory()
            ->make([
                'lieu_vote_id' => $lieuVote->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.lieu-votes.agent-terrains.store', $lieuVote),
            $data
        );

        $this->assertDatabaseHas('agent_terrains', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $agentTerrain = AgentTerrain::latest('id')->first();

        $this->assertEquals($lieuVote->id, $agentTerrain->lieu_vote_id);
    }
}
