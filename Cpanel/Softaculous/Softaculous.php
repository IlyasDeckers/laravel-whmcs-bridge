<?php
namespace App\Phase\Cpanel\Softaculous;

use App\Phase\Cpanel\Cpanel;
use Auth;
use Cache;

class Softaculous extends Cpanel
{
    use InstallApplication,
        ListInstalledApplications,
        GetApplicationFields,
        DeleteApplication;

    protected $data;

    public function __construct($arguments = null)
    {
        $this->data = $arguments;
    }

    public function listApps($data = null)
    {
        $softaculous = new SoftaculousConnect();
        $softaculous->setDomain('server40.phasehosting.io');
        $softaculous->setUser('ilyasde2');
        $softaculous->setPassword('6p94smKgD0');
        return $softaculous->send();
    }
    
    /**
     * List all installations
     *
     * @var $data
     * @return $array
     */
    public function listInstalled($data)
    {   
        /*return $this->execute($data, 'installations');*/
        $softaculous = new SoftaculousConnect();
        $softaculous->setDomain($data['hostname']);
        $softaculous->setUser($data['username']);
        $softaculous->setPassword($data['password']);
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

    public function listAvailable($data)
    {
        return $this->execute($data, 'home');

        $softaculous = new SoftaculousPost();
        $softaculous->setDomain($data['domain']);
        $softaculous->setUser($data['username']);
        $softaculous->setPassword($data['hostname']);

        return $softaculous->send();
    }

    public function listDashboard($category)
    {
        $apps = new \App\Application;
        if($category){
            $apps = $apps->where('category', $category);
        }
        return $apps->get();
    }

    public function install($user, $data)
    {
    
        $softaculous = new SoftaculousConnect();
        $softaculous->setDomain($user['serverhostname']);
        $softaculous->setUser($user['username']);
        $softaculous->setPassword($user['password']);
        $softaculous->setAct('software');
        $softaculous->setSoft($data['softid']);
        
        $softaculousPost = new SoftaculousPost();

        $softaculousPost->setSoftsubmit(1);
        $softaculousPost->setSoftdomain($data['domain']);
        $softaculousPost->setNoemail(1);
        $softaculousPost->setAdminEmail($data['email']);
        $softaculousPost->setSoftdb(1);
        $softaculousPost->setSoftdb('DB_' . rand(0, 100));
        $softaculousPost->setDbusername($user['username']);
        $softaculousPost->setDbuserpass(bin2hex(openssl_random_pseudo_bytes(8)));

        if ($data['softid'] == 470){
            $softaculousPost->setDataDir('nodejs_' . rand(0, 100));
        }

        if ($data['softid'] != 470){
            $softaculousPost->setAdminUsername('tmpadmin');
            $softaculousPost->setAdminPass('testing123');
            
        }

        $softaculous->setPost($softaculousPost);

        return $softaculous->send();
        
    }

    public function delete()
    {
        //
    }

    /**
     * Connect to Softaculous API
     *
     * @var $url
     * @return $array
     *
     */
    private function execute($data, $method = null , $post = null)
    {   
        if(isset($data['hostname'])){
            $hostname = $data['hostname'];
        }else{
            $hostname = $data['serverhostname'];
        }
        
        // The URL
        $url = 'https://' . $data['username'] . ':' . $data['password'] . '@' . $hostname . ':2083/frontend/paper_lantern/softaculous/index.live.php?'.
                    '&api=serialize'.
                    '&act=' . $method;

        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Turn off the server and peer verification (TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        if(!empty($post)){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        }
         
        // Get response from the server.
        $resp = curl_exec($ch);
         
        // The response will hold a string as per the API response method. In this case its PHP Serialize
        $res = unserialize($resp);

        if(isset($res['installations'])){
            $res = $res['installations'];
            if($res != false){
                $res = reset($res);
            }
        }

        return $res;
    }

    private function isLaravel($folder = null)
    {
        $data = array(
            'hostname'  => $this->data['hostname'],
            'username'  => $this->data['username'],
            'domain'    => $this->data['installdomain'],
            'islaravel' => $folder,
            'defaultdomain' => $this->data['domain']
        );

        \Cpanel::deleteAddonDomain($data)->data;
        \Cpanel::createAddonDomain($data);
    }
}
