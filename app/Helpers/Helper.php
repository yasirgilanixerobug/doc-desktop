<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;


/**
 * set global variables for user and role is admin
 */
if (!function_exists('init'))
{
    function init()
    {
        $GLOBALS['user'] = Auth::user();
        $GLOBALS['userId'] = $GLOBALS['user']->id;
        $GLOBALS['clinicId'] = $GLOBALS['user']->clinic_id;
        $GLOBALS['isRoleOwner'] = $GLOBALS['user']->hasRole('owner');
    }
}

if (!function_exists('get_user'))
{
    /**
     * @return Authenticatable|null
     */
    function get_user(): ?Authenticatable
    {
        init();
        return  $GLOBALS['user'];
    }
}

if (!function_exists('get_auth'))
{
    /**
     * @return array
     */
    function get_auth(): array
    {
        init();
        $staffLocationsIds = [];
        foreach ($GLOBALS['user']->staffLocations as $key => $location)
        {
            $staffLocationsIds[] = $location->location_id;
        }
        return [
            'user' => $GLOBALS['user'],
            'userId' => $GLOBALS['userId'],
            'clinicId' => $GLOBALS['clinicId'],
            'isRoleOwner' => $GLOBALS['isRoleOwner'],
            'staffLocationId' => ($GLOBALS['isRoleOwner'] != true) ? $staffLocationsIds  : [0],
        ];
    }
}

if (!function_exists('is_role'))
{
    /**
     * @return mixed
     */
    function is_role($role)
    {
        init();
        return $GLOBALS['user']->hasRole($role);
    }
}

if (!function_exists('get_staff_location_id'))
{
    /**
     * @return int
     */
    function get_staff_location_id()
    {
        init();
        $staffLocationsIds = [];
        foreach ($GLOBALS['user']->staffLocations as $key => $location)
        {
            $staffLocationsIds[] = $location->id;
        }
        return ($GLOBALS['isRoleOwner'] != true) ? $staffLocationsIds  : [0];
    }
}

if (!function_exists('get_date_default_timezone'))
{
    function get_date_default_timezone()
    {
        $cache_file = 'ip_cache.json'; // Specify the cache file path

        if (request()->ip() == '127.0.0.1')
        {
            //$ip = "189.240.194.147"; //$_SERVER['REMOTE_ADDR'];
            //date_default_timezone_set('Asia/Karachi');
            $timezone = 'Asia/Karachi';
        } else {
            // Check if cached IP info exists and is recent
            if (file_exists($cache_file) && (time() - filemtime($cache_file) < 3600)) {
                // If cache file exists and is less than 1 hour old, use cached data
                $cached_data = file_get_contents($cache_file);
                $ipInfo = json_decode($cached_data);
            } else {
                // If cache is outdated or doesn't exist, fetch data from API
                $ip = $_SERVER['REMOTE_ADDR'];
                $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
                // Save fetched data to cache file
                file_put_contents($cache_file, $ipInfo);
                $ipInfo = json_decode($ipInfo);
            }

            $timezone = ($ipInfo != null) ?  $ipInfo->timezone : 'America/Chicago';
        }

        
        return date_default_timezone_set($timezone);
    }
}
