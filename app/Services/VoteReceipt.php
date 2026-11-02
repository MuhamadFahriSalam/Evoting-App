<?php

namespace App\Services;

use App\Models\VoterCredential;

class VoteReceipt
{
    public static function make(VoterCredential $credential): string
    {
        $sig = substr(hash_hmac(
            'sha256',
            $credential->id . '|' . $credential->election_id,
            config('app.key')
        ), 0, 20);

        return $credential->id . '-' . $sig;
    }

    public static function resolve(string $code): ?VoterCredential
    {
        [$id, $sig] = array_pad(explode('-', $code, 2), 2, '');

        if (! ctype_digit($id) || $sig === '') {
            return null;
        }

        $credential = VoterCredential::with('voter')->find((int) $id);

        if (! $credential || ! hash_equals(self::make($credential), $code)) {
            return null;
        }

        return $credential;
    }
}