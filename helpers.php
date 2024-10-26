<?php

if (!function_exists('auth')) {
    /**
     * Get the available auth instance.
     *
     * @return \Tymon\JWTAuth\JWTAuth
     */
    function auth()
    {
        return app('auth');
    }
}

if (!function_exists('bcrypt')) {
    /**
     * Hash the given value.
     *
     * @param string $value
     * @param array $options
     * @return string
     */
    function bcrypt($value, $options = [])
    {
        return app('hash')->make($value, $options);
    }
}

/**
 * Lang function.
 */
if (!function_exists('lang')) {
    /**
     * Get the translated string.
     *
     * @param string $key
     * @return string
     */
    function lang($key)
    {
        return app('translator')->get($key);
    }
}