<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\LieuVote;
use App\Models\BureauVote;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LieuVoteBureauVotesTest extends TestCase
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
    public function it_gets_lieu_vote_bureau_votes()
    {
        $lieuVote = LieuVote::factory()->create();
        $bureauVotes = BureauVote::factory()
            ->count(2)
            ->create([
                'lieu_vote_id' => $lieuVote->id,
            ]);

        $response = $this->getJson(
            route('api.lieu-votes.bureau-votes.index', $lieuVote)
        );

        $response->assertOk()->assertSee($bureauVotes[0]->libel);
    }

    /**
     * @test
     */
    public function it_stores_the_lieu_vote_bureau_votes()
    {
        $lieuVote = LieuVote::factory()->create();
        $data = BureauVote::factory()
            ->make([
                'lieu_vote_id' => $lieuVote->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.lieu-votes.bureau-votes.store', $lieuVote),
            $data
        );

        $this->assertDatabaseHas('bureau_votes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $bureauVote = BureauVote::latest('id')->first();

        $this->assertEquals($lieuVote->id, $bureauVote->lieu_vote_id);
    }
}
