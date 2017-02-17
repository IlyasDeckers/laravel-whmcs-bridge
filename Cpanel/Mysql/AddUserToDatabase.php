<?php
namespace App\Phase\Cpanel\Mysql;

use Servers;

trait AddUserToDatabase
{
    public function addUserToDatabase()
    {
        if (isset($this->newuser)){
            $user = $this->username . '_' . $this->databaseUser;
        } else {
            $user = $this->databaseUser;
        }   

        return json_decode(Servers::initCpanel($this->hostname)
            ->execute_action('3','Mysql','set_privileges_on_database',$this->username,
                array(
                    'user'    => $user,
                    'database'   => $this->databaseName,
                    'privileges' => $this->getPrivileges()
                ) 
            ), true
        )['result'];
    }

    private function getPrivileges()
    {
        return implode(",", $this->privileges);
    }
}