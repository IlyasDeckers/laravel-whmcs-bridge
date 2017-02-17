<?php
namespace App\Phase\Cpanel\Mysql;

use Servers;
use Cache;

trait getDatabaseUsers
{
    public function getDatabaseUsers()
    {
        return json_decode(Servers::initCpanel($this->hostname)
            ->execute_action(
            	'api2','MysqlFE','getdbusers',$this->username
            ),true
        )['cpanelresult']['data'];
    }
}