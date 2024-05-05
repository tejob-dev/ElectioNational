<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Candidat;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CandidatControllerTest extends TestCase
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
    public function it_displays_index_view_with_candidats()
    {
        $candidats = Candidat::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('candidats.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.candidats.index')
            ->assertViewHas('candidats');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_candidat()
    {
        $response = $this->get(route('candidats.create'));

        $response->assertOk()->assertViewIs('app.candidats.create');
    }

    /**
     * @test
     */
    public function it_stores_the_candidat()
    {
        $data = Candidat::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('candidats.store'), $data);

        $this->assertDatabaseHas('candidats', $data);

        $candidat = Candidat::latest('id')->first();

        $response->assertRedirect(route('candidats.edit', $candidat));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_candidat()
    {
        $candidat = Candidat::factory()->create();

        $response = $this->get(route('candidats.show', $candidat));

        $response
            ->assertOk()
            ->assertViewIs('app.candidats.show')
            ->assertViewHas('candidat');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_candidat()
    {
        $candidat = Candidat::factory()->create();

        $response = $this->get(route('candidats.edit', $candidat));

        $response
            ->assertOk()
            ->assertViewIs('app.candidats.edit')
            ->assertViewHas('candidat');
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

        $response = $this->put(route('candidats.update', $candidat), $data);

        $data['id'] = $candidat->id;

        $this->assertDatabaseHas('candidats', $data);

        $response->assertRedirect(route('candidats.edit', $candidat));
    }

    /**
     * @test
     */
    public function it_deletes_the_candidat()
    {
        $candidat = Candidat::factory()->create();

        $response = $this->delete(route('candidats.destroy', $candidat));

        $response->assertRedirect(route('candidats.index'));

        $this->assertDeleted($candidat);
    }
}
