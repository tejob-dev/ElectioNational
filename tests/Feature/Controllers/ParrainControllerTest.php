<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Parrain;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParrainControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_parrains()
    {
        $parrains = Parrain::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('parrains.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.parrains.index')
            ->assertViewHas('parrains');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_parrain()
    {
        $response = $this->get(route('parrains.create'));

        $response->assertOk()->assertViewIs('app.parrains.create');
    }

    /**
     * @test
     */
    public function it_stores_the_parrain()
    {
        $data = Parrain::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('parrains.store'), $data);

        $this->assertDatabaseHas('parrains', $data);

        $parrain = Parrain::latest('id')->first();

        $response->assertRedirect(route('parrains.edit', $parrain));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_parrain()
    {
        $parrain = Parrain::factory()->create();

        $response = $this->get(route('parrains.show', $parrain));

        $response
            ->assertOk()
            ->assertViewIs('app.parrains.show')
            ->assertViewHas('parrain');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_parrain()
    {
        $parrain = Parrain::factory()->create();

        $response = $this->get(route('parrains.edit', $parrain));

        $response
            ->assertOk()
            ->assertViewIs('app.parrains.edit')
            ->assertViewHas('parrain');
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

        $response = $this->put(route('parrains.update', $parrain), $data);

        $data['id'] = $parrain->id;

        $this->assertDatabaseHas('parrains', $data);

        $response->assertRedirect(route('parrains.edit', $parrain));
    }

    /**
     * @test
     */
    public function it_deletes_the_parrain()
    {
        $parrain = Parrain::factory()->create();

        $response = $this->delete(route('parrains.destroy', $parrain));

        $response->assertRedirect(route('parrains.index'));

        $this->assertDeleted($parrain);
    }
}
