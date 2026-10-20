<?php

namespace App\Services;

use App\Models\PhoneNumber;
use App\Models\PhoneNumberOwnership;
use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;
use LogicException;

class PhoneNumberOwnershipService
{
    public function transfer(
        PhoneNumber $phoneNumber,
        int $newSubscriberId
    ): PhoneNumberOwnership {
        return DB::transaction(function () use (
            $phoneNumber,
            $newSubscriberId
        ) {
            $lockedNumber = PhoneNumber::query()
                ->whereKey($phoneNumber->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $subscriber = Subscriber::query()
                ->whereKey($newSubscriberId)
                ->lockForUpdate()
                ->firstOrFail();

            $currentOwnerships = $lockedNumber->ownerships()
                ->whereNull('ended_at')
                ->lockForUpdate()
                ->get();

            if ($currentOwnerships->count() > 1) {
                throw new LogicException(
                    //'توجد سجلات ملكية نشطة متعددة لرقم الهاتف هذا.'
                    'Multiple active ownership records exist for this phone number.',
                );
            }

            $currentOwnership = $currentOwnerships->first();

            if (
                $currentOwnership &&
                (int) $currentOwnership->subscriber_id ===
                (int) $subscriber->getKey()
            ) {
                return $currentOwnership;
            }

            $transferTime = now();

            if ($currentOwnership) {
                $currentOwnership->update([
                    'ended_at' => $transferTime,
                ]);
            }

            return $lockedNumber->ownerships()->create([
                'subscriber_id' => $subscriber->getKey(),
                'started_at' => $transferTime,
                'ended_at' => null,
            ]);
        });
    }
}
