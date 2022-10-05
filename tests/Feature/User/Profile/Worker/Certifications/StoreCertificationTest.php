<?php

namespace Tests\Feature\User\Profile\Worker\Certifications;

use App\Models\Certification;
use App\Models\User;
use App\Models\Worker;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreCertificationTest extends TestCase
{
    use RefreshDatabase;

    private const ROUTE = 'user.profile.worker.certifications.store';

    /**
     * @return void
     */
    public function test_unauthenticated_user_cannot_store_a_certification_in_worker_profile(): void
    {
        $certification = Certification::factory()->make()->toArray();
        $response = $this->post(route(self::ROUTE), $certification);
        $response->assertRedirect('login');
    }

    /**
     * @return void
     */
    public function test_user_non_worker_cannot_store_a_certification_in_worker_profile(): void
    {
        $certification = Certification::factory()->make()->toArray();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route(self::ROUTE), $certification);
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * @return void
     */
    public function test_worker_cannot_store_a_certification_with_empty_data_in_worker_profile(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->actingAs($worker->user);

        $certification = Certification::factory()->make(['name' => ''])->toArray();

        $response = $this->post(route(self::ROUTE))
            ->assertSessionHasErrors(array_keys($certification));

        $response = $this->post(route(self::ROUTE), $certification);
        $response->assertSessionHasErrors(array_keys($certification));
    }

    /**
     * @return void
     */
    public function test_worker_with_existing_certification_cannot_store_same_certification_in_worker_profile(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->actingAs($worker->user);

        $certificationModel = Certification::factory()->withCertifiedUuid()->withCertifiedLink()->make();
        $certification = $certificationModel->toArray();

        $worker->certifications()->save($certificationModel);

        $response = $this->post(route(self::ROUTE), $certification);
        $response->assertSessionHasErrors(['certified_uuid']);
    }

    /**
     * @return void
     */
    public function test_worker_can_store_a_certification_in_worker_profile(): void
    {
        $worker = Worker::factory()->withUser()->create();
        $this->actingAs($worker->user);

        $certification = Certification::factory()
            ->withCertifiedUuid()
            ->withCertifiedLink()
            ->make()
            ->toArray();

        $response = $this->post(route(self::ROUTE), $certification);

        $response->assertRedirect(route('user.profile.worker.certifications.show'))
            ->assertSessionDoesntHaveErrors()
            ->assertSessionHas('store', true);
    }
}
