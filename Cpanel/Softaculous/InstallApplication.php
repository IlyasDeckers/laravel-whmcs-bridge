<?php
namespace App\Phase\Cpanel\Softaculous;

use App\Phase\Cpanel\Cpanel;
use App\Application;
use Exception;
use Cache;
use Auth;

trait InstallApplication
{
    public function installApplication()
    {
        $app = Application::where('softid', $this->data['softid'] )->first();

        $softaculous = new SoftaculousConnect();
        $softaculous->setDomain($this->data['hostname']);
        $softaculous->setUser($this->data['username']);
        $softaculous->setPassword($this->data['password']);
        $softaculous->setAct('software');
        $softaculous->setSoft($this->data['softid']);
        
        $softaculousPost = new SoftaculousPost();

        $softaculousPost->setSoftsubmit(1);
        $softaculousPost->setSoftdomain($this->data['installdomain']);
        $softaculousPost->setNoemail(1);

        if($this->data['softid'] != '419'){
        if($this->data['softid'] != '123'){
            $softaculousPost->setAdminEmail(Auth::user()->email);
            $softaculousPost->setSoftdb(1);
            $softaculousPost->setSoftdb(substr(uniqid('', true), -5));
            $softaculousPost->setDbusername($this->data['username']);
            $softaculousPost->setDbuserpass(bin2hex(openssl_random_pseudo_bytes(8)));
            $softaculousPost->setSoftdirectory('');
            $softaculousPost->setoverwrite_existing(1);
            $softaculousPost->setAdminUsername($this->data['adminusername']);
            $softaculousPost->setAdminPass($this->data['adminpassword']);
            $softaculousPost->setAdminFirstName(Auth::user()->firstname);
            $softaculousPost->setAdminLastName(Auth::user()->lastname);
        }
        }
        

        if ($this->data['softid'] == 470){
            $softaculousPost->setDataDir('nodejs_' . rand(0, 100));
        }

        if ($this->data['softid'] == 144){
            $softaculousPost->setLicenseKey($this->data['license_key']);
        }

        if ($this->data['softid'] == 368){
            
        }

        if ($this->data['softid'] == 26){
            $softaculousPost->setLanguage('en');
            $softaculousPost->setSiteName($this->data['sitename']);
            $softaculousPost->setSiteDesc($this->data['sitedescription']);
            
        }



        $softaculous->setPost($softaculousPost);

        $response = $softaculous->send();

        if(isset($response['error'])){
            foreach($response['error'] as $key => $value){
                throw new Exception($value);
            }
        }

        if($this->data['softid'] == 419){
            $this->islaravel('/public');
        }

        return $response;
        
    }
}
