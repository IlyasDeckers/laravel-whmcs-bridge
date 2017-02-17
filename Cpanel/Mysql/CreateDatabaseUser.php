<?php
namespace App\Phase\Cpanel\Mysql;

use Servers;
use Cache;

trait createDatabaseUser
{
    public function createDatabaseUser()
    {        
		$data = array(
            'name'    => $this->username . '_' . $this->databaseUser,
            'password'   => $this->userPassword,
        );

        return json_decode(Servers::initCpanel($this->hostname)
            ->execute_action(
                '3','Mysql','create_user',$this->username,$data
            ),true
        )['result'];
    }
}