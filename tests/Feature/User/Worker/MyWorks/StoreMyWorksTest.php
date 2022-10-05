<?php

namespace Tests\Feature\User\Worker\MyWorks;

use App\Models\User;
use App\Models\Work;
use App\Models\Worker;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreMyWorksTest extends TestCase
{
    use RefreshDatabase;

    private const ROUTE = 'user.worker.my-works.store';

    /**
     * @return void
     */
    public function test_unauthenticated_user_cannot_store_a_work(): void
    {
        $work = Work::factory()->make()->toArray();
        $response = $this->post(route(self::ROUTE), $work);
        $response->assertRedirect('login');
    }

    /**
     * @return void
     */
    public function test_user_non_worker_cannot_store_a_work(): void
    {
        $work = Work::factory()->make()->toArray();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route(self::ROUTE), $work);
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * @return void
     */
    public function test_worker_cannot_store_a_work_with_empty_data(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->actingAs($worker->user);

        $work = Work::factory()->make(['name' => ''])->toArray();

        $response = $this->post(route(self::ROUTE))
            ->assertSessionHasErrors(['name']);

        $response = $this->post(route(self::ROUTE), $work);
        $response->assertSessionHasErrors(['name']);
    }

    /**
     * @return void
     */
    public function test_worker_can_store_a_work(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->actingAs($worker->user);

        $work = Work::factory()
            ->make()
            ->toArray();

        $response = $this->post(route(self::ROUTE), $work);

        $response->assertRedirect(route('user.worker.my-works'))
            ->assertSessionDoesntHaveErrors()
            ->assertSessionHas('store', true);
    }
}
