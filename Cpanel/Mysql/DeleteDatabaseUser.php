<?php
namespace App\Phase\Cpanel\Mysql;

use Servers;
use Cache;

trait deleteDatabaseUser
{
    public function deleteDatabaseUser()
    {
        return json_decode(Servers::initCpanel($this->hostname)
            ->execute_action(
            	'3','Mysql','delete_user',$this->username,array('name'    => $this->databaseUser) 
        	), true
        )['result'];
    }
}