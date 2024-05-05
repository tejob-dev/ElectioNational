<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\BureauVote;

use App\Models\LieuVote;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BureauVoteTest extends TestCase
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
    public function it_gets_bureau_votes_list()
    {
        $bureauVotes = BureauVote::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.bureau-votes.index'));

        $response->assertOk()->assertSee($bureauVotes[0]->libel);
    }

    /**
     * @test
     */
    public function it_stores_the_bureau_vote()
    {
        $data = BureauVote::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.bureau-votes.store'), $data);

        $this->assertDatabaseHas('bureau_votes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_bureau_vote()
    {
        $bureauVote = BureauVote::factory()->create();

        $lieuVote = LieuVote::factory()->create();

        $data = [
            'libel' => $this->faker->text(255),
            'objectif' => $this->faker->randomNumber(0),
            'seuil' => $this->faker->randomNumber(0),
            'lieu_vote_id' => $lieuVote->id,
        ];

        $response = $this->putJson(
            route('api.bureau-votes.update', $bureauVote),
            $data
        );

        $data['id'] = $bureauVote->id;

        $this->assertDatabaseHas('bureau_votes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_bureau_vote()
    {
        $bureauVote = BureauVote::factory()->create();

        $response = $this->deleteJson(
            route('api.bureau-votes.destroy', $bureauVote)
        );

        $this->assertDeleted($bureauVote);

        $response->assertNoContent();
    }
}
