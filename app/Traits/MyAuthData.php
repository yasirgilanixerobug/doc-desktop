<?php

namespace App\Traits;

trait MyAuthData {

    protected $getAuth;
    protected $authUser;
    protected $authUserIsOwner;
    protected $authUserLocationId;

    function setAuthDataGlobaly()
    {
        $this->getAuth = get_auth();
        $this->authUser = $this->getAuth['user'];
        $this->authUserIsOwner = $this->getAuth['isRoleOwner'];
        $this->authUserLocationId = $this->getAuth['staffLocationId'];
    }
}
