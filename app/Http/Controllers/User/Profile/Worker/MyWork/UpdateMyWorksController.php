<?php

namespace App\Http\Controllers\User\Profile\Worker\MyWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Worker\UpdateMyWorkRequest;
use App\Models\Specialty;
use App\Models\Unity;
use App\Models\Work;
use App\Models\Worker;
use App\Services\Caches\WorkCacheService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class UpdateMyWorksController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  UpdateMyWorkRequest  $request
     * @return RedirectResponse
     */
    public function __invoke(UpdateMyWorkRequest $request): RedirectResponse
    {
        $data = $request->safe();
        $worker = auth()->user()->worker;
        $work = $worker->works()
            ->whereKey($data['id'])
            ->firstOrFail();

        DB::transaction(function () use (&$work, &$data) {
            $work->update([
                ...$data->only(['name', 'description', 'time', 'price']),
                'slug' => $data['name']
            ]);

            $unity = $data['has_unity']
                ? ($data['unity_id'] ?? null)
                : null;

            $this->updateUnity($work, $unity);
            $this->updateSpecialties($work, $data['specialties'] ?? []);
        });

        $this->clearCache($worker);

        return redirect()->route('user.profile.worker.my-works.show');
    }

    /**
     * @param  Work  $work
     * @return void
     */
    private function clearCache(Worker $worker): void
    {
        WorkCacheService::listPaginate(clear: true);
        WorkCacheService::fromWorker($worker, true);
    }

    /**
     * @param  Work  $work
     * @param  int|null  $unityId
     * @return void
     */
    private function updateUnity(Work $work, ?int $unityId): void
    {
        $unity = Unity::find($unityId);
        $work->unity()
            ->associate($unity)
            ->save();
    }

    /**
     * @param  Work  $work
     * @param  array  $specialties
     * @return void
     */
    private function updateSpecialties(Work $work, array $specialties): void
    {
        $specialties = Specialty::query()
            ->whereKey($specialties)
            ->get();

        $work->specialties()->sync($specialties->modelKeys());
    }
}
