<?php

namespace App\Phase\Cpanel\Domains\SubDomains;

use App\Phase\Cpanel\Cpanel;

class SubDomains extends Cpanel
{
    use ListSubDomains, 
        CreateSubDomain, 
        DeleteSubDomain;

    /**
     * Server Hostname
     * 
     * @var string     
     */
    protected $hostname;

    /**
     * Account username on server
     * 
     * @var string     
     */
    protected $username;

    /**
     * The Subdomain
     * 
     * @var string     
     */
    protected $subdomain;

    /**
     * Root Domain
     * 
     * @var string     
     */
    protected $rootdomain;

    /**
     * Subdomain directory
     * 
     * @var string     
     */
    protected $directory;

    /**
     * Wildcard Subdomain
     * 
     * @var boolean     
     */
    protected $wildcard = 0;

    /**
     * [__construct description]
     * 
     * @param array $arguments 
     */
    public function __construct($arguments)
    {
        foreach($arguments as $key => $argument){
            $this->$key = $argument;
        }
    }
}