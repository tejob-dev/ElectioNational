<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Quartier;

use App\Models\Section;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuartierTest extends TestCase
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
    public function it_gets_quartiers_list()
    {
        $quartiers = Quartier::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.quartiers.index'));

        $response->assertOk()->assertSee($quartiers[0]->libel);
    }

    /**
     * @test
     */
    public function it_stores_the_quartier()
    {
        $data = Quartier::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.quartiers.store'), $data);

        $this->assertDatabaseHas('quartiers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_quartier()
    {
        $quartier = Quartier::factory()->create();

        $section = Section::factory()->create();

        $data = [
            'libel' => $this->faker->text(255),
            'nbrinscrit' => $this->faker->randomNumber(0),
            'objectif' => $this->faker->randomNumber(0),
            'seuil' => $this->faker->randomNumber(0),
            'section_id' => $section->id,
        ];

        $response = $this->putJson(
            route('api.quartiers.update', $quartier),
            $data
        );

        $data['id'] = $quartier->id;

        $this->assertDatabaseHas('quartiers', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_quartier()
    {
        $quartier = Quartier::factory()->create();

        $response = $this->deleteJson(
            route('api.quartiers.destroy', $quartier)
        );

        $this->assertDeleted($quartier);

        $response->assertNoContent();
    }
}
