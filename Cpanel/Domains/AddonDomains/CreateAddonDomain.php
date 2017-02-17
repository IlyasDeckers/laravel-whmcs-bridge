<?php

namespace App\Phase\Cpanel\Domains\AddonDomains;

use Servers;

trait CreateAddonDomain
{
    
	public function createAddonDomain()
    {
        $data = array(
            'dir' => $this->domain . '/public_html' . $this->islaravel,
            'newdomain' => $this->domain,
            'subdomain' => $this->removeTdl($this->domain)
        );

        return json_decode(
            Servers::initCpanel($this->hostname)
                ->execute_action('2','AddonDomain','addaddondomain',$this->username, $data),
            true
        )['cpanelresult']['data'][0];
    }
}