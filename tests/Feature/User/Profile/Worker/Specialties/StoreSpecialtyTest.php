<?php

namespace Tests\Feature\User\Profile\Worker\Specialties;

use App\Models\Specialty;
use App\Models\User;
use App\Models\Worker;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreSpecialtyTest extends TestCase
{
    use RefreshDatabase;

    private const ROUTE = 'user.profile.worker.specialties.store';

    /**
     * @return void
     */
    public function test_unauthenticated_user_cannot_store_a_specialty_in_worker_profile(): void
    {
        $specialty = Specialty::first();
        $response = $this->post(route(self::ROUTE), ['specialty' => $specialty->id]);
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
        $response = $this->post(route(self::ROUTE), ['specialty' => $specialty->id]);

        $response->assertRedirect(RouteServiceProvider::HOME);
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


        $response = $this->post(route(self::ROUTE), ['specialty' => $specialty->id]);
        $response->assertSessionHasErrors(['specialty']);
    }

    /**
     * @return void
     */
    public function test_worker_can_store_a_specialty_in_worker_profile(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->actingAs($worker->user);

        $specialty = Specialty::first();

        $response = $this->post(route(self::ROUTE), ['specialty' => $specialty->id]);

        $response->assertRedirect(route('user.profile.worker.specialties.show'))
            ->assertSessionDoesntHaveErrors()
            ->assertSessionHas('store', true);
    }
}
