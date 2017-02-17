<?php
namespace App\Phase\Cpanel\Mysql;

use Servers;
use Cache;

trait CreateDatabase
{
    public function createDatabase()
    {
        $data = array(
            'name'    => $this->username . '_' . $this->databaseName
        );

        return json_decode(Servers::initCpanel($this->hostname)
            ->execute_action(
                '3','Mysql','create_database',$this->username,$data
            ),true
        )['result'];
    }
}