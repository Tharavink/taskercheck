<?php

use JD\Cloudder\Facades\Cloudder;

if (! function_exists('getFromCloudinary')) {
    function getFromCloudinary($public_id, $options = [])
    {
        return Cloudder::secureShow($public_id, $options);
    }
}