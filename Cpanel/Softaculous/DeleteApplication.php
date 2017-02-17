<?php
namespace App\Phase\Cpanel\Softaculous;

use App\Phase\Cpanel\Cpanel;
use Exception;
use Cache;
use Auth;

trait DeleteApplication
{
    public function deleteApplication()
    {
        $softid = explode("_", $this->data['insid'])[0];
        if($softid == 419){
            $this->islaravel();
        }

    	$softaculous = new SoftaculousConnect();
        $softaculous->setDomain($this->data['hostname']);
        $softaculous->setUser($this->data['username']);
        $softaculous->setPassword($this->data['password']);
        $softaculous->setAct('remove');
        $softaculous->setInsId($this->data['insid']);
        
        $softaculousPost = new SoftaculousPost();

        $softaculousPost->setremoveins(1);
        $softaculousPost->setremove_dir(1);
        $softaculousPost->setremove_datadir(1);
        $softaculousPost->setremove_db(1);
        $softaculousPost->setremove_dbuser(1);
        $softaculousPost->setNoemail(1);

        $softaculous->setPost($softaculousPost);

        return $softaculous->send();
    }
}