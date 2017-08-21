<?php

if (!function_exists('setLocaleSystem')) {

    /**
     * Set locale information
     *
     * @return void
     */
    function setLocaleSystem()
    {
        setlocale(LC_ALL, 'en_US.UTF-8');
    }
}


if (!function_exists('currentLoginUser')) {

    /**
     * Get current login user
     *
     * @param string $guard Guard
     *
     * @return \App\Models\Admin
     */
    function currentLoginUser($guard = null)
    {
        return auth($guard ?: 'admin_web')->user();
    }
}
