<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\BureauVote;

use App\Models\LieuVote;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BureauVoteControllerTest extends TestCase
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
    public function it_displays_index_view_with_bureau_votes()
    {
        $bureauVotes = BureauVote::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('bureau-votes.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.bureau_votes.index')
            ->assertViewHas('bureauVotes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_bureau_vote()
    {
        $response = $this->get(route('bureau-votes.create'));

        $response->assertOk()->assertViewIs('app.bureau_votes.create');
    }

    /**
     * @test
     */
    public function it_stores_the_bureau_vote()
    {
        $data = BureauVote::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('bureau-votes.store'), $data);

        $this->assertDatabaseHas('bureau_votes', $data);

        $bureauVote = BureauVote::latest('id')->first();

        $response->assertRedirect(route('bureau-votes.edit', $bureauVote));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_bureau_vote()
    {
        $bureauVote = BureauVote::factory()->create();

        $response = $this->get(route('bureau-votes.show', $bureauVote));

        $response
            ->assertOk()
            ->assertViewIs('app.bureau_votes.show')
            ->assertViewHas('bureauVote');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_bureau_vote()
    {
        $bureauVote = BureauVote::factory()->create();

        $response = $this->get(route('bureau-votes.edit', $bureauVote));

        $response
            ->assertOk()
            ->assertViewIs('app.bureau_votes.edit')
            ->assertViewHas('bureauVote');
    }

    /**
     * @test
     */
    public function it_updates_the_bureau_vote()
    {
        $bureauVote = BureauVote::factory()->create();

        $lieuVote = LieuVote::factory()->create();

        $data = [
            'libel' => $this->faker->text(255),
            'objectif' => $this->faker->randomNumber(0),
            'seuil' => $this->faker->randomNumber(0),
            'lieu_vote_id' => $lieuVote->id,
        ];

        $response = $this->put(
            route('bureau-votes.update', $bureauVote),
            $data
        );

        $data['id'] = $bureauVote->id;

        $this->assertDatabaseHas('bureau_votes', $data);

        $response->assertRedirect(route('bureau-votes.edit', $bureauVote));
    }

    /**
     * @test
     */
    public function it_deletes_the_bureau_vote()
    {
        $bureauVote = BureauVote::factory()->create();

        $response = $this->delete(route('bureau-votes.destroy', $bureauVote));

        $response->assertRedirect(route('bureau-votes.index'));

        $this->assertDeleted($bureauVote);
    }
}
