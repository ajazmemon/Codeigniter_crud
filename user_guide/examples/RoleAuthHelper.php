<?php

namespace App\helper;

use Illuminate\Support\Facades\Auth;
use App\common_route_master;
use Illuminate\Support\Facades\Session;

class RoleAuthHelper
{    
    /**
     * 
     * return all access routes
     */

    /**
     * 
     * return access for routes
     */
    public static function hasAccess($routeName)
    {
      //set for super admin and perticular routes
      return (Auth::user()->can($routeName));
    }
}