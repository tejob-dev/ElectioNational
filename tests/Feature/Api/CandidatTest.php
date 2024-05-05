<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Candidat;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CandidatTest extends TestCase
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
    public function it_gets_candidats_list()
    {
        $candidats = Candidat::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.candidats.index'));

        $response->assertOk()->assertSee($candidats[0]->nom);
    }

    /**
     * @test
     */
    public function it_stores_the_candidat()
    {
        $data = Candidat::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.candidats.store'), $data);

        $this->assertDatabaseHas('candidats', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_candidat()
    {
        $candidat = Candidat::factory()->create();

        $data = [
            'nom' => $this->faker->text(255),
            'prenom' => $this->faker->text(255),
            'code' => $this->faker->text(255),
            'photo' => $this->faker->text(255),
            'couleur' => $this->faker->text(255),
            'parti' => $this->faker->text(255),
        ];

        $response = $this->putJson(
            route('api.candidats.update', $candidat),
            $data
        );

        $data['id'] = $candidat->id;

        $this->assertDatabaseHas('candidats', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_candidat()
    {
        $candidat = Candidat::factory()->create();

        $response = $this->deleteJson(
            route('api.candidats.destroy', $candidat)
        );

        $this->assertDeleted($candidat);

        $response->assertNoContent();
    }
}
