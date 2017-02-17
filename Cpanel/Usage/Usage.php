<?php
namespace App\Phase\Cpanel\Usage;

use App\Http\Controllers\Traits\Actions;
use App\Phase\Cpanel\Cpanel;
use CpanelWhm;
use Exception;
use Servers;
use Cache;

class Usage extends Cpanel
{
	use Actions;

    /**
     * Cpanel Hostname
     * 
     * @var string
     */
    protected $hostname;

    /**
     * Cpanel Account Username
     * 
     * @var string
     */
    protected $username;

    /**
     * LVE information
     * 
     * @var array
     */
    protected $lve;

    /**
     * LVE records limit 
     * 
     * @var array
     */
    protected $limit = 12;

    /**
     * Cpanel information
     * 
     * @var array
     */
    protected $cpanelstats;

    /**
     * Ram usage information
     * 
     * @var array
     */
    protected $ramusage;

    /**
     * Disk usage information
     * 
     * @var array
     */
    protected $diskusage;

    /**
     * Domain usage information
     * 
     * @var array
     */
    protected $addondomains;

    /**
     * Subdomain usage information
     * 
     * @var array
     */
    protected $subdomains;

    /**
     * Database usage information
     * 
     * @var array
     */
    protected $sqldatabases;
    
    /**
     * [__construct description]
     * 
     * @param array $arguments 
     */
    public function __construct($arguments)
    {
        $this->hostname =  $arguments['hostname'];
        $this->username =  $arguments['username'];

        if(isset($arguments['limit']))
        {
            $this->limit = $arguments['limit'];
        }

        $this->lve = array_slice($this->getLVEUsage(), 0, $this->limit);
        $this->cpanelstats = $this->getCpanelStats();
        $this->ramusage = $this->ramUsage();

        foreach($this->cpanelstats as $key => $stats){
            $var = $stats['id'];
            if(!isset($stats['percent'])){
                $stats['percent'] = null;
            }
            $this->$var = array(
                'percent' => $stats['percent'],
                'max' => $stats['max'],
                'used' => $stats['count']
            );
        }
    }

    public function getUsage()
    {
        return array(
            'diskusage'     => $this->diskusage['used'], 
            'maxdisk'       => $this->diskusage['max'],
            'diskperc'      => $this->diskusage['percent'],
            'ramusage'      => $this->ramusage['used'],
            'maxram'        => $this->ramusage['max'],
            'ramperc'       => $this->ramusage['percent'],
            'cpuperc'       => $this->lve[0]['mcpu'],
            'lve'           => array_reverse($this->lve, true),
            'subdomains'    => $this->subdomains(),
            'addonddomains' => $this->addondomains['used'] . '/' . $this->addondomains['max'],
            'databases'     => $this->sqldatabases['used'] . '/' . $this->sqldatabases['max']
        );
    }

    public function getUsageCharts()
    {
        $data = array();
        foreach($this->lve as $lve){
            $ram = $this->formatBytes($lve['aPMem']);
            $maxram = $this->formatBytes($lve['lPMem']);
            $ramPerc = round(($ram / $maxram) * 100);
            $data[] = array(
                'date' => date("Y") . '-' . $lve['from'],
                'cpu'  => $lve['mpcpu'],
                'ram'  => $ramPerc
            );
        }

        return $data;
    }

    private function subdomains()
    {
        $used = $this->subdomains['used'] - $this->addondomains['used'];
        $max = $this->subdomains['max'] - $this->addondomains['max'];

        return $used . '/' . $max;
    }

	private function getLVEUsage()
    {
        $cpanel = Servers::initCpanel($this->hostname);
        return json_decode($cpanel->execute_action('2', 'LVEInfo', 'getUsage', $this->username), true)['cpanelresult']['data'];
    }

    private function getCpanelStats()
    {
        $cpanel = Servers::initCpanel($this->hostname);

        $data = json_decode(
            $cpanel->execute_action('2', 'StatsBar', 'stat', $this->username, array(
                'display'       => 'diskusage|sqldatabases|addondomains|subdomains',
                'warnings'      => '0',
                'warninglevel'   => '0',
                'warnout'       => '0',
                'infinityimg'   => '/home/example/infinity.png',
                'infinitylang'  => 'infinity',
                'rowcounter'    => 'even',
            )), true
        )['cpanelresult']['data'];

        return $data;
    }

    private function ramUsage()
    {
        try {
            $ram = $this->formatBytes($this->lve[0]['aPMem']);
            $maxram = $this->formatBytes($this->lve[0]['lPMem']);
            $ramPerc = round(($ram / $maxram) * 100, -1);
        } catch (Exception $e) {
            $ram = 'Error';
            $maxram = 'Error';
            $ramPerc = 0;
        }

        return array(
            'percent' => $ramPerc,
            'max' => $maxram,
            'used' => $ram
        );
    }
}