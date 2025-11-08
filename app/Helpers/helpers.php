<?php

if (!function_exists('generateApiKey')) {
    function generateApiKey($length = 40)
    {
        // Generate a secure random API key
        return 'SKI' . bin2hex(random_bytes($length));
    }
}
