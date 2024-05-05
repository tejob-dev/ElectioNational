<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Section;
use App\Models\Quartier;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SectionQuartiersTest extends TestCase
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
    public function it_gets_section_quartiers()
    {
        $section = Section::factory()->create();
        $quartiers = Quartier::factory()
            ->count(2)
            ->create([
                'section_id' => $section->id,
            ]);

        $response = $this->getJson(
            route('api.sections.quartiers.index', $section)
        );

        $response->assertOk()->assertSee($quartiers[0]->libel);
    }

    /**
     * @test
     */
    public function it_stores_the_section_quartiers()
    {
        $section = Section::factory()->create();
        $data = Quartier::factory()
            ->make([
                'section_id' => $section->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.sections.quartiers.store', $section),
            $data
        );

        $this->assertDatabaseHas('quartiers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $quartier = Quartier::latest('id')->first();

        $this->assertEquals($section->id, $quartier->section_id);
    }
}
