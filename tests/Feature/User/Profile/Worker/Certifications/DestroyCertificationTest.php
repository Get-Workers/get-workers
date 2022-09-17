<?php

namespace Tests\Feature\User\Profile\Worker\Certifications;

use App\Models\Certification;
use App\Models\Specialty;
use App\Models\User;
use App\Models\Worker;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyCertificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_unauthenticated_user_cannot_delete_a_certification_from_profile(): void
    {
        $certification = str()->uuid();
        $response = $this->delete(route('user.profile.worker.certifications.destroy'), compact('certification'));
        $response->assertRedirect('login');
    }

    /**
     * @return void
     */
    public function test_user_non_worker_cannot_delete_a_certification_from_profile(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $certification = str()->uuid();

        $specialty = Specialty::first();
        $response = $this->delete(route('user.profile.worker.certifications.destroy'), compact('certification'));

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * @return void
     */
    public function test_worker_cannot_delete_a_certification_he_not_owns_from_profile(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->actingAs($worker->user);

        $certification = str()->uuid();

        $response = $this->delete(route('user.profile.worker.certifications.destroy'), compact('certification'));
        $response->assertSessionHasErrors(['certification']);
    }

    /**
     * @return void
     */
    public function test_worker_can_not_delete_certification_from_another_worker_from_profile(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $certification = Certification::factory()->make();
        $worker->certifications()->save($certification);

        $secondWorker = Worker::factory()->withUser()->create();
        $this->actingAs($secondWorker->user);

        $response = $this->delete(route('user.profile.worker.certifications.destroy'), ['certification' => $certification->uuid]);
        $response->assertSessionHasErrors('certification');

    }

    /**
     * @return void
     */
    public function test_worker_can_delete_a_certification_from_profile(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->actingAs($worker->user);

        $certification = Certification::factory()->make();
        $worker->certifications()->save($certification);

        $response = $this->delete(route('user.profile.worker.certifications.destroy'), ['certification' => $certification->uuid])
            ->assertRedirect(route('user.profile.worker.certifications.show'))
            ->assertSessionDoesntHaveErrors()
            ->assertSessionHas('destroy', true);
    }
}
