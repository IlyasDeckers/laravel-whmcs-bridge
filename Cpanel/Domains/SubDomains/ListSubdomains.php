<?php

namespace App\Phase\Cpanel\Domains\SubDomains;

use Servers;

trait ListSubDomains
{
	public function listSubDomains()
    {
        $data = json_decode(
            Servers::initCpanel($this->hostname)
                ->execute_action('2','SubDomain','listsubdomains',$this->username,array())
            , true
        )['cpanelresult']['data'];

        return $data;
    }
}