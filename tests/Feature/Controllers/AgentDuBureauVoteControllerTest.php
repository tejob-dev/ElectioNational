<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\AgentDuBureauVote;

use App\Models\BureauVote;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgentDuBureauVoteControllerTest extends TestCase
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
    public function it_displays_index_view_with_agent_du_bureau_votes()
    {
        $agentDuBureauVotes = AgentDuBureauVote::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('agent-du-bureau-votes.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.agent_du_bureau_votes.index')
            ->assertViewHas('agentDuBureauVotes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_agent_du_bureau_vote()
    {
        $response = $this->get(route('agent-du-bureau-votes.create'));

        $response->assertOk()->assertViewIs('app.agent_du_bureau_votes.create');
    }

    /**
     * @test
     */
    public function it_stores_the_agent_du_bureau_vote()
    {
        $data = AgentDuBureauVote::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('agent-du-bureau-votes.store'), $data);

        $this->assertDatabaseHas('agent_du_bureau_votes', $data);

        $agentDuBureauVote = AgentDuBureauVote::latest('id')->first();

        $response->assertRedirect(
            route('agent-du-bureau-votes.edit', $agentDuBureauVote)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_agent_du_bureau_vote()
    {
        $agentDuBureauVote = AgentDuBureauVote::factory()->create();

        $response = $this->get(
            route('agent-du-bureau-votes.show', $agentDuBureauVote)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.agent_du_bureau_votes.show')
            ->assertViewHas('agentDuBureauVote');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_agent_du_bureau_vote()
    {
        $agentDuBureauVote = AgentDuBureauVote::factory()->create();

        $response = $this->get(
            route('agent-du-bureau-votes.edit', $agentDuBureauVote)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.agent_du_bureau_votes.edit')
            ->assertViewHas('agentDuBureauVote');
    }

    /**
     * @test
     */
    public function it_updates_the_agent_du_bureau_vote()
    {
        $agentDuBureauVote = AgentDuBureauVote::factory()->create();

        $bureauVote = BureauVote::factory()->create();

        $data = [
            'nom' => $this->faker->text(255),
            'prenom' => $this->faker->text(255),
            'telphone' => $this->faker->text(255),
            'bureau_vote_id' => $bureauVote->id,
        ];

        $response = $this->put(
            route('agent-du-bureau-votes.update', $agentDuBureauVote),
            $data
        );

        $data['id'] = $agentDuBureauVote->id;

        $this->assertDatabaseHas('agent_du_bureau_votes', $data);

        $response->assertRedirect(
            route('agent-du-bureau-votes.edit', $agentDuBureauVote)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_agent_du_bureau_vote()
    {
        $agentDuBureauVote = AgentDuBureauVote::factory()->create();

        $response = $this->delete(
            route('agent-du-bureau-votes.destroy', $agentDuBureauVote)
        );

        $response->assertRedirect(route('agent-du-bureau-votes.index'));

        $this->assertDeleted($agentDuBureauVote);
    }
}
