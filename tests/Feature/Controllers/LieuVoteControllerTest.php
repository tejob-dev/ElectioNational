<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\LieuVote;

use App\Models\Quartier;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LieuVoteControllerTest extends TestCase
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
    public function it_displays_index_view_with_lieu_votes()
    {
        $lieuVotes = LieuVote::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('lieu-votes.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.lieu_votes.index')
            ->assertViewHas('lieuVotes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_lieu_vote()
    {
        $response = $this->get(route('lieu-votes.create'));

        $response->assertOk()->assertViewIs('app.lieu_votes.create');
    }

    /**
     * @test
     */
    public function it_stores_the_lieu_vote()
    {
        $data = LieuVote::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('lieu-votes.store'), $data);

        $this->assertDatabaseHas('lieu_votes', $data);

        $lieuVote = LieuVote::latest('id')->first();

        $response->assertRedirect(route('lieu-votes.edit', $lieuVote));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_lieu_vote()
    {
        $lieuVote = LieuVote::factory()->create();

        $response = $this->get(route('lieu-votes.show', $lieuVote));

        $response
            ->assertOk()
            ->assertViewIs('app.lieu_votes.show')
            ->assertViewHas('lieuVote');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_lieu_vote()
    {
        $lieuVote = LieuVote::factory()->create();

        $response = $this->get(route('lieu-votes.edit', $lieuVote));

        $response
            ->assertOk()
            ->assertViewIs('app.lieu_votes.edit')
            ->assertViewHas('lieuVote');
    }

    /**
     * @test
     */
    public function it_updates_the_lieu_vote()
    {
        $lieuVote = LieuVote::factory()->create();

        $quartier = Quartier::factory()->create();

        $data = [
            'code' => $this->faker->unique->text(255),
            'libel' => $this->faker->text(255),
            'nbrinscrit' => $this->faker->randomNumber(0),
            'objectif' => $this->faker->randomNumber(0),
            'seuil' => $this->faker->randomNumber(0),
            'quartier_id' => $quartier->id,
        ];

        $response = $this->put(route('lieu-votes.update', $lieuVote), $data);

        $data['id'] = $lieuVote->id;

        $this->assertDatabaseHas('lieu_votes', $data);

        $response->assertRedirect(route('lieu-votes.edit', $lieuVote));
    }

    /**
     * @test
     */
    public function it_deletes_the_lieu_vote()
    {
        $lieuVote = LieuVote::factory()->create();

        $response = $this->delete(route('lieu-votes.destroy', $lieuVote));

        $response->assertRedirect(route('lieu-votes.index'));

        $this->assertDeleted($lieuVote);
    }
}
