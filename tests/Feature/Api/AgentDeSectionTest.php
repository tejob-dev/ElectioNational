<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\AgentDeSection;

use App\Models\Section;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgentDeSectionTest extends TestCase
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
    public function it_gets_agent_de_sections_list()
    {
        $agentDeSections = AgentDeSection::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.agent-de-sections.index'));

        $response->assertOk()->assertSee($agentDeSections[0]->nom);
    }

    /**
     * @test
     */
    public function it_stores_the_agent_de_section()
    {
        $data = AgentDeSection::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.agent-de-sections.store'),
            $data
        );

        $this->assertDatabaseHas('agent_de_sections', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.agent-de-sections.update', $agentDeSection),
            $data
        );

        $data['id'] = $agentDeSection->id;

        $this->assertDatabaseHas('agent_de_sections', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_agent_de_section()
    {
        $agentDeSection = AgentDeSection::factory()->create();

        $response = $this->deleteJson(
            route('api.agent-de-sections.destroy', $agentDeSection)
        );

        $this->assertDeleted($agentDeSection);

        $response->assertNoContent();
    }
}
