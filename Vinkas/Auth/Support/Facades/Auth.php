<?php

namespace Vinkas\Auth\Support\Facades;

class Auth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'vinkas.auth'; }
}
