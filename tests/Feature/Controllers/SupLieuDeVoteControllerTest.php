<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SupLieuDeVote;

use App\Models\LieuVote;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupLieuDeVoteControllerTest extends TestCase
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
    public function it_displays_index_view_with_sup_lieu_de_votes()
    {
        $supLieuDeVotes = SupLieuDeVote::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('sup-lieu-de-votes.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.sup_lieu_de_votes.index')
            ->assertViewHas('supLieuDeVotes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_sup_lieu_de_vote()
    {
        $response = $this->get(route('sup-lieu-de-votes.create'));

        $response->assertOk()->assertViewIs('app.sup_lieu_de_votes.create');
    }

    /**
     * @test
     */
    public function it_stores_the_sup_lieu_de_vote()
    {
        $data = SupLieuDeVote::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('sup-lieu-de-votes.store'), $data);

        $this->assertDatabaseHas('sup_lieu_de_votes', $data);

        $supLieuDeVote = SupLieuDeVote::latest('id')->first();

        $response->assertRedirect(
            route('sup-lieu-de-votes.edit', $supLieuDeVote)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_sup_lieu_de_vote()
    {
        $supLieuDeVote = SupLieuDeVote::factory()->create();

        $response = $this->get(route('sup-lieu-de-votes.show', $supLieuDeVote));

        $response
            ->assertOk()
            ->assertViewIs('app.sup_lieu_de_votes.show')
            ->assertViewHas('supLieuDeVote');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_sup_lieu_de_vote()
    {
        $supLieuDeVote = SupLieuDeVote::factory()->create();

        $response = $this->get(route('sup-lieu-de-votes.edit', $supLieuDeVote));

        $response
            ->assertOk()
            ->assertViewIs('app.sup_lieu_de_votes.edit')
            ->assertViewHas('supLieuDeVote');
    }

    /**
     * @test
     */
    public function it_updates_the_sup_lieu_de_vote()
    {
        $supLieuDeVote = SupLieuDeVote::factory()->create();

        $lieuVote = LieuVote::factory()->create();

        $data = [
            'nom' => $this->faker->text(255),
            'prenom' => $this->faker->text(255),
            'telephone' => $this->faker->text(255),
            'lieu_vote_id' => $lieuVote->id,
        ];

        $response = $this->put(
            route('sup-lieu-de-votes.update', $supLieuDeVote),
            $data
        );

        $data['id'] = $supLieuDeVote->id;

        $this->assertDatabaseHas('sup_lieu_de_votes', $data);

        $response->assertRedirect(
            route('sup-lieu-de-votes.edit', $supLieuDeVote)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_sup_lieu_de_vote()
    {
        $supLieuDeVote = SupLieuDeVote::factory()->create();

        $response = $this->delete(
            route('sup-lieu-de-votes.destroy', $supLieuDeVote)
        );

        $response->assertRedirect(route('sup-lieu-de-votes.index'));

        $this->assertDeleted($supLieuDeVote);
    }
}
