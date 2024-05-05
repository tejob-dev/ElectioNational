<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\AgentDeSection;

use App\Models\Section;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgentDeSectionControllerTest extends TestCase
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
    public function it_displays_index_view_with_agent_de_sections()
    {
        $agentDeSections = AgentDeSection::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('agent-de-sections.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.agent_de_sections.index')
            ->assertViewHas('agentDeSections');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_agent_de_section()
    {
        $response = $this->get(route('agent-de-sections.create'));

        $response->assertOk()->assertViewIs('app.agent_de_sections.create');
    }

    /**
     * @test
     */
    public function it_stores_the_agent_de_section()
    {
        $data = AgentDeSection::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('agent-de-sections.store'), $data);

        $this->assertDatabaseHas('agent_de_sections', $data);

        $agentDeSection = AgentDeSection::latest('id')->first();

        $response->assertRedirect(
            route('agent-de-sections.edit', $agentDeSection)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_agent_de_section()
    {
        $agentDeSection = AgentDeSection::factory()->create();

        $response = $this->get(
            route('agent-de-sections.show', $agentDeSection)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.agent_de_sections.show')
            ->assertViewHas('agentDeSection');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_agent_de_section()
    {
        $agentDeSection = AgentDeSection::factory()->create();

        $response = $this->get(
            route('agent-de-sections.edit', $agentDeSection)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.agent_de_sections.edit')
            ->assertViewHas('agentDeSection');
    }

    /**
     * @test
     */
    public function it_updates_the_agent_de_section()
    {
        $agentDeSection = AgentDeSection::factory()->create();

        $section = Section::factory()->create();

        $data = [
            'nom' => $this->faker->text(255),
            'prenom' => $this->faker->text(255),
            'telephone' => $this->faker->text(255),
            'section_id' => $section->id,
        ];

        $response = $this->put(
            route('agent-de-sections.update', $agentDeSection),
            $data
        );

        $data['id'] = $agentDeSection->id;

        $this->assertDatabaseHas('agent_de_sections', $data);

        $response->assertRedirect(
            route('agent-de-sections.edit', $agentDeSection)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_agent_de_section()
    {
        $agentDeSection = AgentDeSection::factory()->create();

        $response = $this->delete(
            route('agent-de-sections.destroy', $agentDeSection)
        );

        $response->assertRedirect(route('agent-de-sections.index'));

        $this->assertDeleted($agentDeSection);
    }
}
