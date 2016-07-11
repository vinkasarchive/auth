<?php

namespace Vinkas;

use Illuminate\Support\Str;

class Auth {

    public function generateRandomCode()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }

}
