<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Quartier;
use App\Models\LieuVote;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuartierLieuVotesTest extends TestCase
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
    public function it_gets_quartier_lieu_votes()
    {
        $quartier = Quartier::factory()->create();
        $lieuVotes = LieuVote::factory()
            ->count(2)
            ->create([
                'quartier_id' => $quartier->id,
            ]);

        $response = $this->getJson(
            route('api.quartiers.lieu-votes.index', $quartier)
        );

        $response->assertOk()->assertSee($lieuVotes[0]->code);
    }

    /**
     * @test
     */
    public function it_stores_the_quartier_lieu_votes()
    {
        $quartier = Quartier::factory()->create();
        $data = LieuVote::factory()
            ->make([
                'quartier_id' => $quartier->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.quartiers.lieu-votes.store', $quartier),
            $data
        );

        $this->assertDatabaseHas('lieu_votes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $lieuVote = LieuVote::latest('id')->first();

        $this->assertEquals($quartier->id, $lieuVote->quartier_id);
    }
}
