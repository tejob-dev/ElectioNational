<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Section;
use App\Models\AgentDeSection;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SectionAgentDeSectionsTest extends TestCase
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
    public function it_gets_section_agent_de_sections()
    {
        $section = Section::factory()->create();
        $agentDeSections = AgentDeSection::factory()
            ->count(2)
            ->create([
                'section_id' => $section->id,
            ]);

        $response = $this->getJson(
            route('api.sections.agent-de-sections.index', $section)
        );

        $response->assertOk()->assertSee($agentDeSections[0]->nom);
    }

    /**
     * @test
     */
    public function it_stores_the_section_agent_de_sections()
    {
        $section = Section::factory()->create();
        $data = AgentDeSection::factory()
            ->make([
                'section_id' => $section->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.sections.agent-de-sections.store', $section),
            $data
        );

        $this->assertDatabaseHas('agent_de_sections', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $agentDeSection = AgentDeSection::latest('id')->first();

        $this->assertEquals($section->id, $agentDeSection->section_id);
    }
}
