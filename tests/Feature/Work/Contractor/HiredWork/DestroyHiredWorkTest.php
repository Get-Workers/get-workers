<?php

namespace Tests\Feature\Work\Contractor\HiredWork;

use App\Models\Contractor;
use App\Models\HiredWork;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyHiredWorkTest extends TestCase
{
    use RefreshDatabase;

    private const ROUTE = 'user.contractor.hired-works.destroy';

    /**
     * @return void
     */
    public function test_unauthenticated_user_cannot_destroy_a_hired_work(): void
    {
        $hiredWork = HiredWork::factory()->withWork()->withContractor()->create();
        $response = $this->delete(route(self::ROUTE), ['hiredWork' => $hiredWork->uuid]);
        $response->assertRedirect('login');
    }

    /**
     * @return void
     */
    public function test_user_non_contractor_cannot_destroy_a_hired_work(): void
    {
        $hiredWork = HiredWork::factory()->withWork()->withContractor()->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(route(self::ROUTE), ['hiredWork' => $hiredWork->uuid]);
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * @return void
     */
    public function test_contractor_cannot_destroy_a_hired_work_with_empty_data(): void
    {
        $contractor = Contractor::factory()->withUser()->create();
        $this->actingAs($contractor->user);

        $response = $this->delete(route(self::ROUTE));
        $response->assertSessionHasErrors(['hiredWork']);

        $response = $this->delete(route(self::ROUTE), ['hiredWork' => '']);
        $response->assertSessionHasErrors(['hiredWork']);
    }

    /**
     * @return void
     */
    public function test_contractor_cannot_destroy_a_not_owned_hired_work(): void
    {
        $contractor = Contractor::factory()->withUser()->create();
        $this->actingAs($contractor->user);

        $secondContractor = Contractor::factory()->withUser()->create();
        $hiredWork = HiredWork::factory(['contractor_id' => $secondContractor->id])
            ->withWork()
            ->initiated()
            ->create();

        $response = $this->delete(route(self::ROUTE), ['hiredWork' => $hiredWork->uuid]);
        $response->assertSessionHasErrors(['hiredWork']);
    }

    /**
     * @return void
     */
    public function test_contractor_cannot_destroy_a_hired_work_that_has_initiated(): void
    {
        $contractor = Contractor::factory()->withUser()->create();
        $this->actingAs($contractor->user);

        $hiredWork = HiredWork::factory(['contractor_id' => $contractor->id])
            ->withWork()
            ->initiated()
            ->create();

        $response = $this->delete(route(self::ROUTE), ['hiredWork' => $hiredWork->uuid]);
        $response->assertSessionHasErrors(['hiredWork']);
    }

    /**
     * @return void
     */
    public function test_contractor_can_destroy_a_hired_work(): void
    {
        $contractor = Contractor::factory()->withUser()->create();
        $this->actingAs($contractor->user);

        $hiredWork = HiredWork::factory(['contractor_id' => $contractor->id])
            ->withWork()
            ->create();

        $response = $this->delete(route(self::ROUTE), ['hiredWork' => $hiredWork->uuid]);
        $response->assertRedirect(route('user.contractor.hired-works.list'));
        $response->assertSessionDoesntHaveErrors();
        $response->assertSessionHas('destroy', true);

        $this->assertDatabaseMissing(HiredWork::class, ['uuid' => $hiredWork->uuid]);
    }
}
