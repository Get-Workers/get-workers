<?php

namespace Tests\Feature\User\Worker\HiredWork;

use App\Models\HiredWork;
use App\Models\Worker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class InitiateHiredWorkTest extends TestCase
{
    use RefreshDatabase;

    private const ROUTE = 'user.profile.worker.hired-works.initiate';

    /**
     * @return void
     */
    public function test_unautenticated_user_cannot_initiate_hired_work()
    {
        $hiredWork = HiredWork::factory()->withWork()->withContractor()->create();
        $response = $this->post(route(self::ROUTE), ['hiredWork' => $hiredWork->uuid]);
        $response->assertRedirect('login');
    }

    /**
     * @return void
     */
    public function test_worker_cannot_initiate_hired_work_that_not_owns()
    {
        $worker = Worker::factory()->withUser()->create();
        $secondWorker = Worker::factory()->withUser()->create();
        $hiredWork = HiredWork::factory()->withWork($worker)->withContractor()->create();
        $response = $this->actingAs($secondWorker->user)
            ->post(route(self::ROUTE), ['hiredWork' => $hiredWork->uuid]);
        $response->assertSessionHasErrors(['hiredWork']);
    }

    /**
     * @return void
     */
    public function test_cannot_initiate_hired_work_that_has_already_initiated()
    {
        $worker = Worker::factory()->withUser()->create();
        $hiredWork = HiredWork::factory()
            ->withWork($worker)
            ->withContractor()
            ->initiated()
            ->create();

        $response = $this->actingAs($worker->user)
            ->post(route(self::ROUTE), ['hiredWork' => $hiredWork->uuid]);

        $response->assertStatus(Response::HTTP_FOUND)
            ->assertSessionHasErrors(['hiredWork']);
    }

    /**
     * @return void
     */
    public function test_can_initiate_hired_work()
    {
        $worker = Worker::factory()->withUser()->create();
        $hiredWork = HiredWork::factory()
            ->withWork($worker)
            ->withContractor()
            ->create();

        $response = $this->actingAs($worker->user)
            ->post(route(self::ROUTE), ['hiredWork' => $hiredWork->uuid]);

        $response->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect(route('user.profile.worker.hired-works.show', ['hiredWorkUuid' => $hiredWork->uuid]));
        $this->assertDatabaseMissing(HiredWork::class, ['id' => $hiredWork, 'initiated_at' => null]);
    }
}
