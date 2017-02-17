<?php
namespace App\Phase\Cpanel\Mysql;

use Servers;
use Cache;

trait listDatabases
{
    public function listDatabases()
    {
        $data = array(
            'regex' => '*'
        );

        return json_decode(Servers::initCpanel($this->hostname)
            ->execute_action(
                'api2','MysqlFE','listdbs',$this->username,$data
            ),true
        )['cpanelresult']['data'];
    }
}