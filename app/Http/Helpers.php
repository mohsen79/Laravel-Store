<?php

use Illuminate\Support\Facades\Route;

function IsActive($key, $active = 'active')
{
    if (is_array($key)) {
        return in_array(Route::getFacadeRoot()->current()->uri(), $key) ? $active : '';
    }
    return Route::getFacadeRoot()->current()->uri() == $key ? $active : '';
}
