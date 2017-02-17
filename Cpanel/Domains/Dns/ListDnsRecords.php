<?php

namespace App\Phase\Cpanel\Domains\Dns;

use Servers;

trait ListDnsRecords
{
	public function listDnsRecords()
    {
        $records = json_decode(
            Servers::initCpanel($this->hostname)->dumpzone(
                'domain=' . $this->domain
            ), true
        )['result'][0]['record'];

    	$A = $this->search($records, 'type', 'A');
        $NS = $this->search($records, 'type', 'NS');
        $MX = $this->search($records, 'type', 'MX');
        $TXT = $this->search($records, 'type', 'TXT');
        $CNAME = $this->search($records, 'type', 'CNAME');
        
        $data = array_merge_recursive($NS, $A, $CNAME, $TXT, $MX);

        return $data;
    }

    private function belonsToUser()
    {
    	// Check
    }
}