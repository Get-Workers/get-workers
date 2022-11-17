<?php

namespace App\Http\Controllers\User\Profile\Worker\MyWork;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Worker\StoreMyWorkRequest;
use App\Models\Specialty;
use App\Models\Unity;
use App\Models\Work;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class StoreMyWorksController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\User\Worker\StoreMyWorkRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(StoreMyWorkRequest $request): RedirectResponse
    {
        $worker = auth()->user()->worker;

        $validatedInputs = $request->safe();

        DB::transaction(function () use (&$worker, &$validatedInputs) {
            $inputFields = $validatedInputs->only(['name', 'description', 'time', 'price']);

            $newWork = $worker->works()->create([...$inputFields, 'slug' => $inputFields['name']]);

            $unity = $validatedInputs['unity_id'] ?? null;

            $this->associateUnity($newWork, $unity);
            $this->associateSpecialties($newWork, $validatedInputs['specialties'] ?? []);
        });


        return redirect()->route('user.profile.worker.my-works.show');
    }

    private function associateUnity(Work $work, ?int $unityId): void
    {
        if (is_null($unityId)) return;

        $unity = Unity::findOrFail($unityId);
        $work->unity()
            ->associate($unity)
            ->save();
    }

    private function associateSpecialties(Work $work, array $specialties): void
    {
        if (empty($specialties)) return;

        $specialties = Specialty::query()
            ->whereKey($specialties)
            ->get();

        $work->specialties()->saveMany($specialties);
    }
}
