<?php
namespace App\Phase\Cpanel\Domains\Dns;

use App\Phase\Cpanel\Cpanel;

class Dns extends Cpanel
{
	use ListDnsRecords;

	protected $hostname;

	protected $username;

	protected $domain;

    public function __construct($arguments)
    {
        $this->hostname = $arguments['hostname'];
        $this->username = $arguments['username'];
        $this->domain = $arguments['domain'];
    }
}