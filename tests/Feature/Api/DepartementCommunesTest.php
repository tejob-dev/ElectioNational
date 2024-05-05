<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Commune;
use App\Models\Departement;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartementCommunesTest extends TestCase
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
    public function it_gets_departement_communes()
    {
        $departement = Departement::factory()->create();
        $commune = Commune::factory()->create();

        $departement->communes()->attach($commune);

        $response = $this->getJson(
            route('api.departements.communes.index', $departement)
        );

        $response->assertOk()->assertSee($commune->libel);
    }

    /**
     * @test
     */
    public function it_can_attach_communes_to_departement()
    {
        $departement = Departement::factory()->create();
        $commune = Commune::factory()->create();

        $response = $this->postJson(
            route('api.departements.communes.store', [$departement, $commune])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $departement
                ->communes()
                ->where('communes.id', $commune->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_communes_from_departement()
    {
        $departement = Departement::factory()->create();
        $commune = Commune::factory()->create();

        $response = $this->deleteJson(
            route('api.departements.communes.store', [$departement, $commune])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $departement
                ->communes()
                ->where('communes.id', $commune->id)
                ->exists()
        );
    }
}
