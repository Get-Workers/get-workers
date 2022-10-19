<?php

namespace Tests\Feature\Work\Contractor\HiredWork;

use App\Models\Contractor;
use App\Models\User;
use App\Models\Work;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreHiredWorkTest extends TestCase
{
    use RefreshDatabase;

    private const ROUTE = 'hired-works.store';

    /**
     * @return void
     */
    public function test_unauthenticated_user_cannot_store_a_hired_work(): void
    {
        $work = Work::factory()->withWorker()->create();
        $response = $this->post(route(self::ROUTE), ['work' => $work->uuid]);
        $response->assertRedirect('login');
    }

    /**
     * @return void
     */
    public function test_user_non_contractor_cannot_store_a_hired_work(): void
    {
        $work = Work::factory()->withWorker()->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route(self::ROUTE), ['work' => $work->uuid]);
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * @return void
     */
    public function test_contractor_cannot_store_a_hired_work_with_empty_data(): void
    {
        $contractor = Contractor::factory()->withUser()->create();
        $this->actingAs($contractor->user);

        $response = $this->post(route(self::ROUTE))
            ->assertSessionHasErrors(['work']);

        $response = $this->post(route(self::ROUTE), ['work' => '']);
        $response->assertSessionHasErrors(['work']);
    }

    /**
     * @return void
     */
    public function test_contractor_can_store_a_hired_work(): void
    {
        $contractor = Contractor::factory()->withUser()->create();
        $this->actingAs($contractor->user);

        $work = Work::factory()->withWorker()->create();

        $response = $this->post(route(self::ROUTE), ['work' => $work->uuid]);

        $response->assertRedirect(route('works.show', ['workUuid' => $work->uuid]))
            ->assertSessionDoesntHaveErrors()
            ->assertSessionHas('store', true);
    }
}
