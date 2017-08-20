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
     * @return \App\Models\Admin
     */
    function currentLoginUser()
    {
        return auth()->loginUsingId(1);
        return auth('admin_web')->user();
    }
}
