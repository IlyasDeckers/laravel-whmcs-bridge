<?php
namespace App\Phase\Cpanel\SSO;

use App\Phase\Cpanel\Cpanel;
use App\Server;

class Session extends Cpanel
{
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
     * [__construct description]
     * 
     * @param array $arguments 
     */
    public function __construct($arguments)
    {
        $this->hostname =  $arguments['hostname'];
        $this->username =  $arguments['username'];
    }

    /**
     * get FileManager Url
     * 
     * @return string 
     */
    public function fileManager()
    {     
        return $this->send('FileManager_Home');
    }

    /**
     * get PhpMyAdmin Url
     * 
     * @return string 
     */
    public function phpMyAdmin()
    {     
        return $this->send('Database_phpMyAdmin');
    }

    /**
     * get PhpMyAdmin Url
     * 
     * @return string 
     */
    public function cpanelManager()
    {     
        return $this->send('cpaneld');
    }

    private function send($app)
    {
        $query = 'https://server7.phasehosting.io:2087/json-api/create_user_session?api.version=1&user=' . $this->username . '&service=cpaneld&app=' . $app;
          
        $curl = curl_init();                                     // Create Curl Object.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);       // Allow self-signed certificates...
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);       // and certificates that don't match the hostname.
        curl_setopt($curl, CURLOPT_HEADER, false);               // Do not include header in output
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);        // Return contents of transfer on curl_exec.
        $header[0] = 'Authorization: ' . "WHM root:" . str_replace("\r\n",'', Server::where('hostname', $this->hostname)->first()->accesshash);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);         // Set the username and password.
        curl_setopt($curl, CURLOPT_URL, $query);                 // Execute the query.
        $result = curl_exec($curl);
        if ($result == false) {
            error_log("curl_exec threw error \"" . curl_error($curl) . "\" for $query");
                                                            // log error if curl exec fails
        }

        return json_decode($result, true)['data']['url'];
    }
}