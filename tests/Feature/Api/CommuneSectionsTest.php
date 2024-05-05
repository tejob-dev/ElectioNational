<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Commune;
use App\Models\Section;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommuneSectionsTest extends TestCase
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
    public function it_gets_commune_sections()
    {
        $commune = Commune::factory()->create();
        $sections = Section::factory()
            ->count(2)
            ->create([
                'commune_id' => $commune->id,
            ]);

        $response = $this->getJson(
            route('api.communes.sections.index', $commune)
        );

        $response->assertOk()->assertSee($sections[0]->libel);
    }

    /**
     * @test
     */
    public function it_stores_the_commune_sections()
    {
        $commune = Commune::factory()->create();
        $data = Section::factory()
            ->make([
                'commune_id' => $commune->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.communes.sections.store', $commune),
            $data
        );

        $this->assertDatabaseHas('sections', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $section = Section::latest('id')->first();

        $this->assertEquals($commune->id, $section->commune_id);
    }
}
