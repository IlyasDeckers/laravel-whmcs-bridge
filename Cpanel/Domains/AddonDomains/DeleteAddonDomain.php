<?php
namespace App\Phase\Cpanel\Domains\AddonDomains;

use Servers;
use Cache;
use Auth;

trait DeleteAddonDomain
{
	public function deleteAddonDomain()
    {
        $data = array(
            'domain' => $this->domain,
            'subdomain' => $this->removeTdl($this->domain) . '.' . $this->defaultDomain
        ); 

        return json_decode(Servers::initCpanel($this->hostname)
            ->execute_action('2','AddonDomain','deladdondomain',$this->username,$data), true
        )['cpanelresult']['data'][0];
    }
}