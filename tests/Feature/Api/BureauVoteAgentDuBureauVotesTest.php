<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\BureauVote;
use App\Models\AgentDuBureauVote;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BureauVoteAgentDuBureauVotesTest extends TestCase
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
    public function it_gets_bureau_vote_agent_du_bureau_votes()
    {
        $bureauVote = BureauVote::factory()->create();
        $agentDuBureauVotes = AgentDuBureauVote::factory()
            ->count(2)
            ->create([
                'bureau_vote_id' => $bureauVote->id,
            ]);

        $response = $this->getJson(
            route('api.bureau-votes.agent-du-bureau-votes.index', $bureauVote)
        );

        $response->assertOk()->assertSee($agentDuBureauVotes[0]->nom);
    }

    /**
     * @test
     */
    public function it_stores_the_bureau_vote_agent_du_bureau_votes()
    {
        $bureauVote = BureauVote::factory()->create();
        $data = AgentDuBureauVote::factory()
            ->make([
                'bureau_vote_id' => $bureauVote->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.bureau-votes.agent-du-bureau-votes.store', $bureauVote),
            $data
        );

        $this->assertDatabaseHas('agent_du_bureau_votes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $agentDuBureauVote = AgentDuBureauVote::latest('id')->first();

        $this->assertEquals(
            $bureauVote->id,
            $agentDuBureauVote->bureau_vote_id
        );
    }
}
