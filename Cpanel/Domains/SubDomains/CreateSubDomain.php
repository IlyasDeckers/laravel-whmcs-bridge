<?php

namespace App\Phase\Cpanel\Domains\SubDomains;

use Servers;

trait CreateSubDomain
{
	public function createsubDomain()
    {
        $data = array(
            'domain'                => $this->domain,
            'rootdomain'            => $this->rootdomain,
            'directory'             => $this->directory,
        );

        return json_decode(
            Servers::initCpanel($this->hostname)
                ->execute_action('2','SubDomain','addsubdomain',$this->username, $data),
            true
        )['cpanelresult']['data'][0];
    }
}