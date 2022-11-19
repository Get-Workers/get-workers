<?php

namespace App\Actions\Worker\Profile;

use App\Models\PhoneNumber;
use App\Models\Worker;
use Illuminate\Support\Collection;

class UpdatePhoneNumbersAction
{
    /**
     * @param  Worker  $worker
     * @param  array  $phoneNumbers
     * @return boolean
     */
    public function update(Worker $worker, array $phoneNumbers): bool
    {
        $numbers = $this->getOrCreateNumbers($phoneNumbers);

        $worker->phoneNumbers()->sync($numbers);

        // $notValidatedNumbers = $worker->phoneNumbers()
        //     ->wherePivotNull('validated_at')
        //     ->get();

        return true;
    }

    private function getOrCreateNumbers(array $phoneNumbers): Collection
    {
        $numbers = collect();

        foreach ($phoneNumbers as $phoneNumber) {
            $number = PhoneNumber::firstOrCreate($phoneNumber['phone_number'])->id;
            $numbers->add($number);
        }

        return $numbers;
    }
}
