<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Parrain;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParrainTest extends TestCase
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
    public function it_gets_parrains_list()
    {
        $parrains = Parrain::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.parrains.index'));

        $response->assertOk()->assertSee($parrains[0]->nom_pren_par);
    }

    /**
     * @test
     */
    public function it_stores_the_parrain()
    {
        $data = Parrain::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.parrains.store'), $data);

        $this->assertDatabaseHas('parrains', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_parrain()
    {
        $parrain = Parrain::factory()->create();

        $data = [
            'nom_pren_par' => $this->faker->text(255),
            'telephone_par' => $this->faker->text(255),
            'nom' => $this->faker->text(255),
            'prenom' => $this->faker->text(255),
            'cart_milit' => 'Oui',
            'list_elect' => $this->faker->text(255),
            'cart_elect' => $this->faker->text(255),
            'telephone' => $this->faker->text(255),
            'date_naiss' => $this->faker->date,
            'code_lv' => $this->faker->text(255),
            'residence' => $this->faker->text(255),
            'profession' => $this->faker->text(255),
            'observation' => $this->faker->sentence(15),
        ];

        $response = $this->putJson(
            route('api.parrains.update', $parrain),
            $data
        );

        $data['id'] = $parrain->id;

        $this->assertDatabaseHas('parrains', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_parrain()
    {
        $parrain = Parrain::factory()->create();

        $response = $this->deleteJson(route('api.parrains.destroy', $parrain));

        $this->assertDeleted($parrain);

        $response->assertNoContent();
    }
}
