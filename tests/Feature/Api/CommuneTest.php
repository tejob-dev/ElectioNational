<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Commune;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommuneTest extends TestCase
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
    public function it_gets_communes_list()
    {
        $communes = Commune::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.communes.index'));

        $response->assertOk()->assertSee($communes[0]->libel);
    }

    /**
     * @test
     */
    public function it_stores_the_commune()
    {
        $data = Commune::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.communes.store'), $data);

        $this->assertDatabaseHas('communes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_commune()
    {
        $commune = Commune::factory()->create();

        $data = [
            'libel' => $this->faker->text(255),
            'nbrinscrit' => $this->faker->randomNumber,
            'objectif' => $this->faker->randomNumber(0),
            'seuil' => $this->faker->randomNumber(0),
        ];

        $response = $this->putJson(
            route('api.communes.update', $commune),
            $data
        );

        $data['id'] = $commune->id;

        $this->assertDatabaseHas('communes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_commune()
    {
        $commune = Commune::factory()->create();

        $response = $this->deleteJson(route('api.communes.destroy', $commune));

        $this->assertDeleted($commune);

        $response->assertNoContent();
    }
}
