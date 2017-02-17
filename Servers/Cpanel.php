<?php
namespace App\Phase\Severs;

use App\Server;

class Cpanel extends Servers
{
	public function initCpanel($host)
    {
        return new \Phase\CpanelPhp\Cpanel([
            'host'        =>  'https://' . $host .':2087',
            'username'    =>  'root',
            'auth_type'   =>  'hash',
            'password'    =>  $this->accessHash($host),
        ]); 
    }

    private function accessHash($host) 
    {
        return Server::where('hostname', $host)->first()->accesshash;
    }
}