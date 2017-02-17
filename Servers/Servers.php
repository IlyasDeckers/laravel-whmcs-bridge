<?php
namespace App\Phase\Servers;

use App\Server;
use Whmcs;
use Api;

class Servers
{
    public function initCpanel($host)
    {
        try {
            $init = new \Phase\CpanelPhp\Cpanel([
                'host'        =>  'https://' . $host .':2087',
                'username'    =>  'root',
                'auth_type'   =>  'hash',
                'password'    =>  $this->accessHash($host),
            ]); 
        } catch (Exception $e){
            dd('No access keys configured');
        }

        return $init;
    }

    private function accessHash($host) 
    {
        return Server::where('hostname', $host)->first()->accesshash;
    }

    public function getServerSatus($host) 
    {
        $cpanel = $this->initCpanel($host);
        $status = $cpanel->execute_action('3', 'servicestatus', '', 'phasedev');
        return Api::respondSuccess($status);
    }
	
    public function getServersFromWhmcs()
    {
        try {

            $servers = $this->getServers();

        } catch (\Exception $e) {

            return false;

        }

        $fromDb = Server::all();
        
        Server::truncate();

        foreach ($servers as $key => $server) {
            if (Server::where('hostname', $server['hostname'])->first() == null) {
                $this->serversToDb($server);
            } 
        }

        /*foreach ($fromDb as $key => $db) {
            if ($db['accesshash'] != null) {
                $data = array(['accesshash' => $db['accesshash'], 'hostname' => $db['hostname']]);
                $this->addKey($data);
            }
        }*/

        return true;
    }

    public function addKey($data)
    {
        try {
            $server = Server::where('hostname', $data['hostname'])->first();
            $server->accesshash = $data['accesshash'];
            $server->save();
            return $server;
        } catch (Exception $e) {
            return [];
        }        
    }

    private function getServers()
    {
        return \Whmcs::execute('GetServers', array('fetchStatus' => true))['servers'];
    }

    private function serversToDb($server)
    {
        $s = new Server;
        $s->name = $server['name'];
        $s->hostname = $server['hostname'];
        $s->ipaddress = $server['ipaddress'];
        $s->save();
    }
}