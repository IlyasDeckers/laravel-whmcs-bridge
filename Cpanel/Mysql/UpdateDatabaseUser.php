<?php
namespace App\Phase\Cpanel\Mysql;

use Servers;

trait updateDatabaseUser
{
    public function updateDatabaseUser()
    {
        return json_decode(Servers::initCpanel($this->hostname)
            ->execute_action('3','Mysql','set_password',$this->username,
                array(
                    'user'    => $this->databaseUser,
                    'password' => $this->userPassword
                ) 
            ), true
        );
    }
}