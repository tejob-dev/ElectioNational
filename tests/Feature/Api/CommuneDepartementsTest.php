<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Commune;
use App\Models\Departement;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommuneDepartementsTest extends TestCase
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
    public function it_gets_commune_departements()
    {
        $commune = Commune::factory()->create();
        $departement = Departement::factory()->create();

        $commune->departements()->attach($departement);

        $response = $this->getJson(
            route('api.communes.departements.index', $commune)
        );

        $response->assertOk()->assertSee($departement->libel);
    }

    /**
     * @test
     */
    public function it_can_attach_departements_to_commune()
    {
        $commune = Commune::factory()->create();
        $departement = Departement::factory()->create();

        $response = $this->postJson(
            route('api.communes.departements.store', [$commune, $departement])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $commune
                ->departements()
                ->where('departements.id', $departement->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_departements_from_commune()
    {
        $commune = Commune::factory()->create();
        $departement = Departement::factory()->create();

        $response = $this->deleteJson(
            route('api.communes.departements.store', [$commune, $departement])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $commune
                ->departements()
                ->where('departements.id', $departement->id)
                ->exists()
        );
    }
}
