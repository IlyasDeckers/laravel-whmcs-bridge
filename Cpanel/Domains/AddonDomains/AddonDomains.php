<?php

namespace App\Phase\Cpanel\Domains\AddonDomains;

use App\Phase\Cpanel\Cpanel;

class AddonDomains extends Cpanel
{
    use ListAddonDomains, 
        CreateAddonDomain, 
        DeleteAddonDomain;

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
     * The addon domain
     * 
     * @var string     
     */
    protected $domain;

    /**
     * The main domain
     * 
     * @var string     
     */
    protected $defaultDomain;

    /**
     * The main domain
     * 
     * @var string     
     */
    protected $islaravel;

    /**
     * [__construct description]
     * 
     * @param array $arguments 
     */
    public function __construct($arguments)
    {
        $this->hostname = $arguments['hostname'];
        $this->username = $arguments['username'];
    
        if(isset($arguments['domain'])){
            $this->domain = $arguments['domain'];
        }
        
        if(isset($arguments['defaultdomain'])){
            $this->defaultDomain = $arguments['defaultdomain'];
        }

        if(isset($arguments['islaravel'])){
            $this->islaravel = $arguments['islaravel'];
        }
    }

    public function removeTdl($data)
    {
        return preg_split('/(?=\.[^.]+$)/', $data)[0];
    }
}