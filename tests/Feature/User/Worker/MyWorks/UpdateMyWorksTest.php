<?php

namespace Tests\Feature\User\Worker\MyWorks;

use App\Models\Work;
use App\Models\Worker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateMyWorksTest extends TestCase
{
    use RefreshDatabase;

    private const ROUTE = 'user.profile.worker.my-works.update';

    /**
     * @return void
     */
    public function test_unauthenticated_user_cannot_update_a_work(): void
    {
        $work = Work::factory()->withWorker()->create()->toArray();
        $response = $this->put(route(self::ROUTE), $work);
        $response->assertRedirect('login');
    }

    /**
     * @return void
     */
    public function test_worker_cannot_update_a_work_with_empty_data(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->actingAs($worker->user);

        $work = Work::factory()->create(['worker_id' => $worker]);
        $workData = $work->toArray();
        $workData['name'] = '';

        $response = $this->put(route(self::ROUTE), $workData);

        $response->assertSessionHasErrors(['name']);
    }

    /**
     * @return void
     */
    public function test_worker_can_update_a_work(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->actingAs($worker->user);

        $work = Work::factory()->create(['worker_id' => $worker]);
        $workData = $work->toArray();
        $workData['name'] = 'teste';

        $response = $this->put(route(self::ROUTE), $workData);

        $response->assertRedirect(route('user.profile.worker.my-works.show'))
            ->assertSessionDoesntHaveErrors();
    }
}
