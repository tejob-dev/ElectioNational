<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Commune;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommuneUsersTest extends TestCase
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
    public function it_gets_commune_users()
    {
        $commune = Commune::factory()->create();
        $users = User::factory()
            ->count(2)
            ->create([
                'commune_id' => $commune->id,
            ]);

        $response = $this->getJson(route('api.communes.users.index', $commune));

        $response->assertOk()->assertSee($users[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_commune_users()
    {
        $commune = Commune::factory()->create();
        $data = User::factory()
            ->make([
                'commune_id' => $commune->id,
            ])
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(
            route('api.communes.users.store', $commune),
            $data
        );

        unset($data['password']);
        unset($data['email_verified_at']);

        $this->assertDatabaseHas('users', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $user = User::latest('id')->first();

        $this->assertEquals($commune->id, $user->commune_id);
    }
}
