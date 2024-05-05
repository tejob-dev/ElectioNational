<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ProcesVerbal;

use App\Models\BureauVote;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProcesVerbalControllerTest extends TestCase
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
    public function it_displays_index_view_with_proces_verbals()
    {
        $procesVerbals = ProcesVerbal::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('proces-verbals.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.proces_verbals.index')
            ->assertViewHas('procesVerbals');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_proces_verbal()
    {
        $response = $this->get(route('proces-verbals.create'));

        $response->assertOk()->assertViewIs('app.proces_verbals.create');
    }

    /**
     * @test
     */
    public function it_stores_the_proces_verbal()
    {
        $data = ProcesVerbal::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('proces-verbals.store'), $data);

        $this->assertDatabaseHas('proces_verbals', $data);

        $procesVerbal = ProcesVerbal::latest('id')->first();

        $response->assertRedirect(route('proces-verbals.edit', $procesVerbal));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_proces_verbal()
    {
        $procesVerbal = ProcesVerbal::factory()->create();

        $response = $this->get(route('proces-verbals.show', $procesVerbal));

        $response
            ->assertOk()
            ->assertViewIs('app.proces_verbals.show')
            ->assertViewHas('procesVerbal');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_proces_verbal()
    {
        $procesVerbal = ProcesVerbal::factory()->create();

        $response = $this->get(route('proces-verbals.edit', $procesVerbal));

        $response
            ->assertOk()
            ->assertViewIs('app.proces_verbals.edit')
            ->assertViewHas('procesVerbal');
    }

    /**
     * @test
     */
    public function it_updates_the_proces_verbal()
    {
        $procesVerbal = ProcesVerbal::factory()->create();

        $bureauVote = BureauVote::factory()->create();

        $data = [
            'libel' => $this->faker->text(255),
            'photo' => $this->faker->text(255),
            'bureau_vote_id' => $bureauVote->id,
        ];

        $response = $this->put(
            route('proces-verbals.update', $procesVerbal),
            $data
        );

        $data['id'] = $procesVerbal->id;

        $this->assertDatabaseHas('proces_verbals', $data);

        $response->assertRedirect(route('proces-verbals.edit', $procesVerbal));
    }

    /**
     * @test
     */
    public function it_deletes_the_proces_verbal()
    {
        $procesVerbal = ProcesVerbal::factory()->create();

        $response = $this->delete(
            route('proces-verbals.destroy', $procesVerbal)
        );

        $response->assertRedirect(route('proces-verbals.index'));

        $this->assertDeleted($procesVerbal);
    }
}
