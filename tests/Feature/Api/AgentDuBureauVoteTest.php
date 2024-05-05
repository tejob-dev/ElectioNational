<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\AgentDuBureauVote;

use App\Models\BureauVote;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgentDuBureauVoteTest extends TestCase
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
    public function it_gets_agent_du_bureau_votes_list()
    {
        $agentDuBureauVotes = AgentDuBureauVote::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.agent-du-bureau-votes.index'));

        $response->assertOk()->assertSee($agentDuBureauVotes[0]->nom);
    }

    /**
     * @test
     */
    public function it_stores_the_agent_du_bureau_vote()
    {
        $data = AgentDuBureauVote::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.agent-du-bureau-votes.store'),
            $data
        );

        $this->assertDatabaseHas('agent_du_bureau_votes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.agent-du-bureau-votes.update', $agentDuBureauVote),
            $data
        );

        $data['id'] = $agentDuBureauVote->id;

        $this->assertDatabaseHas('agent_du_bureau_votes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_agent_du_bureau_vote()
    {
        $agentDuBureauVote = AgentDuBureauVote::factory()->create();

        $response = $this->deleteJson(
            route('api.agent-du-bureau-votes.destroy', $agentDuBureauVote)
        );

        $this->assertDeleted($agentDuBureauVote);

        $response->assertNoContent();
    }
}
