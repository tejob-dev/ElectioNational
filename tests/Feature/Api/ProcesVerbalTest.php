<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ProcesVerbal;

use App\Models\BureauVote;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProcesVerbalTest extends TestCase
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
    public function it_gets_proces_verbals_list()
    {
        $procesVerbals = ProcesVerbal::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.proces-verbals.index'));

        $response->assertOk()->assertSee($procesVerbals[0]->libel);
    }

    /**
     * @test
     */
    public function it_stores_the_proces_verbal()
    {
        $data = ProcesVerbal::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.proces-verbals.store'), $data);

        $this->assertDatabaseHas('proces_verbals', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_proces_verbal()
    {
        $procesVerbal = ProcesVerbal::factory()->create();

        $bureauVote = BureauVote::factory()->create();

        $data = [
            'libel' => $this->faker->text(255),
            'photo' => $this->faker->text(255),
            'bureau_vote_id' => $bureauVote->id,
        ];

        $response = $this->putJson(
            route('api.proces-verbals.update', $procesVerbal),
            $data
        );

        $data['id'] = $procesVerbal->id;

        $this->assertDatabaseHas('proces_verbals', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_proces_verbal()
    {
        $procesVerbal = ProcesVerbal::factory()->create();

        $response = $this->deleteJson(
            route('api.proces-verbals.destroy', $procesVerbal)
        );

        $this->assertDeleted($procesVerbal);

        $response->assertNoContent();
    }
}
