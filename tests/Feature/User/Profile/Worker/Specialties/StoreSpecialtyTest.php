<?php

namespace Tests\Feature\User\Profile\Worker\Specialties;

use App\Models\Specialty;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class StoreSpecialtyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_unauthenticated_user_cannot_store_a_specialty_in_worker_profile(): void
    {
        $specialty = Specialty::first();
        $response = $this->post(route('user.profile.worker.specialties.store'), ['specialtyId' => $specialty->id]);
        $response->assertRedirect('login');
    }

    /**
     * @return void
     */
    public function test_user_non_worker_cannot_store_a_specialty_in_worker_profile(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $specialty = Specialty::first();
        $response = $this->post(route('user.profile.worker.specialties.store'), ['specialtyId' => $specialty->id]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @return void
     */
    public function test_worker_with_existing_specialty_cannot_store_same_specialty_in_worker_profile(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->actingAs($worker->user);

        $specialty = Specialty::first();
        $worker->specialties()->save($specialty);


        $response = $this->post(route('user.profile.worker.specialties.store'), ['specialtyId' => $specialty->id]);
        $response->assertSessionHasErrors(['specialtyId']);
    }

    /**
     * @return void
     */
    public function test_worker_can_store_a_specialty_in_worker_profile(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->actingAs($worker->user);

        $specialties = Specialty::all();
        $specialties->each(function (Specialty $specialty) {
            $response = $this->post(route('user.profile.worker.specialties.store'), ['specialtyId' => $specialty->id]);

            $response->assertRedirect(route('user.profile.worker.specialties.show'))
                ->assertSessionDoesntHaveErrors()
                ->assertSessionHas('store', true);
        });
    }
}
