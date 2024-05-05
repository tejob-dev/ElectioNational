<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\BureauVote;
use App\Models\ProcesVerbal;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BureauVoteProcesVerbalsTest extends TestCase
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
    public function it_gets_bureau_vote_proces_verbals()
    {
        $bureauVote = BureauVote::factory()->create();
        $procesVerbals = ProcesVerbal::factory()
            ->count(2)
            ->create([
                'bureau_vote_id' => $bureauVote->id,
            ]);

        $response = $this->getJson(
            route('api.bureau-votes.proces-verbals.index', $bureauVote)
        );

        $response->assertOk()->assertSee($procesVerbals[0]->libel);
    }

    /**
     * @test
     */
    public function it_stores_the_bureau_vote_proces_verbals()
    {
        $bureauVote = BureauVote::factory()->create();
        $data = ProcesVerbal::factory()
            ->make([
                'bureau_vote_id' => $bureauVote->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.bureau-votes.proces-verbals.store', $bureauVote),
            $data
        );

        $this->assertDatabaseHas('proces_verbals', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $procesVerbal = ProcesVerbal::latest('id')->first();

        $this->assertEquals($bureauVote->id, $procesVerbal->bureau_vote_id);
    }
}
