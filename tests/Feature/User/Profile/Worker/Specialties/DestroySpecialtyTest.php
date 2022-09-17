<?php

namespace Tests\Feature\User\Profile\Worker\Specialties;

use App\Models\Specialty;
use App\Models\User;
use App\Models\Worker;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroySpecialtyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_unauthenticated_user_cannot_delete_a_specialty_from_profile(): void
    {
        $specialty = Specialty::first();
        $response = $this->delete(route('user.profile.worker.specialties.destroy'), ['specialty' => $specialty->id]);
        $response->assertRedirect('login');
    }

    /**
     * @return void
     */
    public function test_user_non_worker_cannot_delete_a_specialty_from_profile(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $specialty = Specialty::first();
        $response = $this->delete(route('user.profile.worker.specialties.destroy'), ['specialty' => $specialty->id]);

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * @return void
     */
    public function test_worker_without_specialties_cannot_delete_a_specialty_from_profile(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->actingAs($worker->user);

        $specialty = Specialty::first();

        $response = $this->delete(route('user.profile.worker.specialties.destroy'), ['specialty' => $specialty->id]);
        $response->assertSessionHasErrors(['specialty']);
    }

    /**
     * @return void
     */
    public function test_worker_can_not_delete_specialties_from_another_worker_from_profile(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->seedSpecialtyToWorker($worker);

        $secondWorker = Worker::factory()->withUser()->create();
        $this->actingAs($secondWorker->user);

        $specialty = $worker->specialties()->first();

        $response = $this->delete(route('user.profile.worker.specialties.destroy'), ['specialty' => $specialty->id]);
        $response->assertSessionHasErrors('specialty');

    }

    /**
     * @return void
     */
    public function test_worker_can_delete_a_specialty_from_profile(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->seedSpecialtyToWorker($worker);
        $this->actingAs($worker->user);

        $specialty = $worker->specialties()->first();

        $response = $this->delete(route('user.profile.worker.specialties.destroy'), ['specialty' => $specialty->id]);
        $response->assertRedirect(route('user.profile.worker.specialties.show'))
            ->assertSessionDoesntHaveErrors()
            ->assertSessionHas('destroy', true);
    }

    /**
     * @param  Worker  $worker
     * @return void
     */
    private function seedSpecialtyToWorker(Worker $worker): void
    {
        $specialties = Specialty::all();
        $worker->specialties()->saveMany($specialties);
    }
}
