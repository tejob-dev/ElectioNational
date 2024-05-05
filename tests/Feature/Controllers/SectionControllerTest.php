<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Section;

use App\Models\Commune;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SectionControllerTest extends TestCase
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
    public function it_displays_index_view_with_sections()
    {
        $sections = Section::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('sections.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.sections.index')
            ->assertViewHas('sections');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_section()
    {
        $response = $this->get(route('sections.create'));

        $response->assertOk()->assertViewIs('app.sections.create');
    }

    /**
     * @test
     */
    public function it_stores_the_section()
    {
        $data = Section::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('sections.store'), $data);

        $this->assertDatabaseHas('sections', $data);

        $section = Section::latest('id')->first();

        $response->assertRedirect(route('sections.edit', $section));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_section()
    {
        $section = Section::factory()->create();

        $response = $this->get(route('sections.show', $section));

        $response
            ->assertOk()
            ->assertViewIs('app.sections.show')
            ->assertViewHas('section');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_section()
    {
        $section = Section::factory()->create();

        $response = $this->get(route('sections.edit', $section));

        $response
            ->assertOk()
            ->assertViewIs('app.sections.edit')
            ->assertViewHas('section');
    }

    /**
     * @test
     */
    public function it_updates_the_section()
    {
        $section = Section::factory()->create();

        $commune = Commune::factory()->create();

        $data = [
            'libel' => $this->faker->text(255),
            'nbrinscrit' => $this->faker->randomNumber(0),
            'objectif' => $this->faker->randomNumber(0),
            'seuil' => $this->faker->randomNumber(0),
            'commune_id' => $commune->id,
        ];

        $response = $this->put(route('sections.update', $section), $data);

        $data['id'] = $section->id;

        $this->assertDatabaseHas('sections', $data);

        $response->assertRedirect(route('sections.edit', $section));
    }

    /**
     * @test
     */
    public function it_deletes_the_section()
    {
        $section = Section::factory()->create();

        $response = $this->delete(route('sections.destroy', $section));

        $response->assertRedirect(route('sections.index'));

        $this->assertDeleted($section);
    }
}
