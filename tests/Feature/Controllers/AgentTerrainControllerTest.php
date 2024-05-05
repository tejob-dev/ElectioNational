<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\AgentTerrain;

use App\Models\LieuVote;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgentTerrainControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_agent_terrains()
    {
        $agentTerrains = AgentTerrain::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('agent-terrains.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.agent_terrains.index')
            ->assertViewHas('agentTerrains');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_agent_terrain()
    {
        $response = $this->get(route('agent-terrains.create'));

        $response->assertOk()->assertViewIs('app.agent_terrains.create');
    }

    /**
     * @test
     */
    public function it_stores_the_agent_terrain()
    {
        $data = AgentTerrain::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('agent-terrains.store'), $data);

        $this->assertDatabaseHas('agent_terrains', $data);

        $agentTerrain = AgentTerrain::latest('id')->first();

        $response->assertRedirect(route('agent-terrains.edit', $agentTerrain));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_agent_terrain()
    {
        $agentTerrain = AgentTerrain::factory()->create();

        $response = $this->get(route('agent-terrains.show', $agentTerrain));

        $response
            ->assertOk()
            ->assertViewIs('app.agent_terrains.show')
            ->assertViewHas('agentTerrain');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_agent_terrain()
    {
        $agentTerrain = AgentTerrain::factory()->create();

        $response = $this->get(route('agent-terrains.edit', $agentTerrain));

        $response
            ->assertOk()
            ->assertViewIs('app.agent_terrains.edit')
            ->assertViewHas('agentTerrain');
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

        $response = $this->put(
            route('agent-terrains.update', $agentTerrain),
            $data
        );

        $data['id'] = $agentTerrain->id;

        $this->assertDatabaseHas('agent_terrains', $data);

        $response->assertRedirect(route('agent-terrains.edit', $agentTerrain));
    }

    /**
     * @test
     */
    public function it_deletes_the_agent_terrain()
    {
        $agentTerrain = AgentTerrain::factory()->create();

        $response = $this->delete(
            route('agent-terrains.destroy', $agentTerrain)
        );

        $response->assertRedirect(route('agent-terrains.index'));

        $this->assertDeleted($agentTerrain);
    }
}
