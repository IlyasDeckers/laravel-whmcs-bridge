<?php
namespace App\Phase\Cpanel\Softaculous;

use App\Phase\Cpanel\Cpanel;

trait ListInstalledApplications
{
    protected $installed = [];

    public function listInstalledApplications()
    {
        $softaculous = new SoftaculousConnect();
        $softaculous->setDomain($this->data['hostname']);
        $softaculous->setUser($this->data['username']);
        $softaculous->setPassword($this->data['password']);
        $softaculous->setAct('installations');

        $installed = $softaculous->send()['installations'];

        $installed = (object) $installed;

        $installs = []; 
        foreach($installed as $key => $install){
            foreach($install as $key => $inst){
                $name = \App\Application::where('softid', $inst['sid'])->first();  
                $inst['name'] = $name->name;
                $installs[] = $inst;
            }            
        }

        return $installs;
    }
}
