<?php
namespace App\Phase\Cpanel\Mysql;

use Servers;
use Cache;

trait DeleteDatabase
{
    public function DeleteDatabase()
    {
        $data = array(
            'name' => $this->databaseName
        );

        Cache::forget('product_mysql_' . $this->username);

        return json_decode(Servers::initCpanel($this->hostname)
        	->execute_action(
                '3','Mysql','delete_database',$this->username,$data
            ),true
        )['result'];
    }
}