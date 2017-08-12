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