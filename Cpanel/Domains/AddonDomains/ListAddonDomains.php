<?php

namespace App\Phase\Cpanel\Domains\AddonDomains;

use Servers;
use Cache;
use Auth;

trait ListAddonDomains
{
	public function listAddonDomains()
    {
        $data = json_decode(
            Servers::initCpanel($this->hostname)
                ->execute_action('2','AddonDomain','listaddondomains',$this->username,array())
            , true
        )['cpanelresult']['data'];

        return $data;
    }
}