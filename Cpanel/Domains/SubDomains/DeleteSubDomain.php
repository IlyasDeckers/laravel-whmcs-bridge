<?php

namespace App\Phase\Cpanel\Domains\SubDomains;

use Servers;

trait DeleteSubDomain
{
	public function deleteSubDomain()
    {
    	$data = array(
            'domain' => $this->subdomain . '.' . $this->rootdomain
        );

        return json_decode(
            Servers::initCpanel($this->hostname)
                ->execute_action('2','SubDomain','delsubdomain',$this->username, $data),
            true
        )['cpanelresult']['data'][0];
    }
}