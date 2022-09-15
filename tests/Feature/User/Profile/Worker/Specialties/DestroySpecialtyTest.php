<?php

namespace Tests\Feature\User\Profile\Worker\Specialties;

use App\Models\Specialty;
use App\Models\User;
use App\Models\Worker;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
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
        $response = $this->post(route('user.profile.worker.specialties.destroy'), ['specialtyId' => $specialty->id]);
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
        $response = $this->post(route('user.profile.worker.specialties.destroy'), ['specialtyId' => $specialty->id]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return void
     */
    public function test_worker_without_specialties_cannot_delete_a_specialty_from_profile(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->actingAs($worker->user);

        $specialty = Specialty::first();

        $response = $this->post(route('user.profile.worker.specialties.destroy'), ['specialtyId' => $specialty->id]);
        $response->assertSessionHasErrors(['specialtyId']);
    }

    /**
     * @return void
     */
    public function test_worker_can_delete_a_specialty_from_profile(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->seedSpecialtyToWorker($worker);

        $this->actingAs($worker->user);
        $worker->specialties->each(function (Specialty $specialty) {
            $response = $this->post(route('user.profile.worker.specialties.destroy'), ['specialtyId' => $specialty->id]);


            $response->assertRedirect(route('user.profile.worker.specialties.show'))
                ->assertSessionDoesntHaveErrors()
                ->assertSessionHas('destroy', true);
        });
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