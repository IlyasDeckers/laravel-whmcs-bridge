<?php
namespace App\Phase\Cpanel\Mysql;

use App\Phase\Cpanel\Cpanel;

class Mysql extends Cpanel
{
    use AddUserToDatabase,
        ListDatabases, 
        CreateDatabase, 
        CreateDatabaseUser,
        DeleteDatabase,
        DeleteDatabaseUser, 
        GetDatabaseUsers,
        UpdateDatabaseUser;

    /**
     * Server Hostname
     * 
     * @var string     
     */
    protected $hostname;

    /**
     * Account username on server
     * 
     * @var string     
     */
    protected $username;

    /**
     * Account username on server
     * 
     * @var string     
     */
    protected $databaseName; 

    /**
     * Account username on server
     * 
     * @var string     
     */
    protected $databaseUser;

    /**
     * Account password on server
     * 
     * @var string     
     */
    protected $userPassword;

    /**
     * Create new user True/False
     * 
     * @var boolean
     */
    protected $newUser;

    /**
     * User database privileges
     * 
     * @var array
     */
    protected $privileges;

    /**
     * [__construct description]
     * 
     * @param array $arguments 
     */
    public function __construct($arguments)
    {
        foreach($arguments as $key => $argument){
            $this->$key = $argument;
        }
    }
}