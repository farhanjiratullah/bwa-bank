<?php

use App\Models\Wallet;

function pinChecker($pin)
{
    $wallet = Wallet::whereUserId(auth()->id())->firstOr(fn () => false);

    if ($wallet->pin !== $pin) return false;

    return true;
}
