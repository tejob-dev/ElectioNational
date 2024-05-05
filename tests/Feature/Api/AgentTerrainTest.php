<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\AgentTerrain;

use App\Models\LieuVote;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgentTerrainTest extends TestCase
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
    public function it_gets_agent_terrains_list()
    {
        $agentTerrains = AgentTerrain::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.agent-terrains.index'));

        $response->assertOk()->assertSee($agentTerrains[0]->nom);
    }

    /**
     * @test
     */
    public function it_stores_the_agent_terrain()
    {
        $data = AgentTerrain::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.agent-terrains.store'), $data);

        $this->assertDatabaseHas('agent_terrains', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_agent_terrain()
    {
        $agentTerrain = AgentTerrain::factory()->create();

        $lieuVote = LieuVote::factory()->create();

        $data = [
            'nom' => $this->faker->text(255),
            'prenom' => $this->faker->text(255),
            'code' => $this->faker->unique->text(255),
            'telephone' => $this->faker->unique->text(255),
            'lieu_vote_id' => $lieuVote->id,
        ];

        $response = $this->putJson(
            route('api.agent-terrains.update', $agentTerrain),
            $data
        );

        $data['id'] = $agentTerrain->id;

        $this->assertDatabaseHas('agent_terrains', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_agent_terrain()
    {
        $agentTerrain = AgentTerrain::factory()->create();

        $response = $this->deleteJson(
            route('api.agent-terrains.destroy', $agentTerrain)
        );

        $this->assertDeleted($agentTerrain);

        $response->assertNoContent();
    }
}
