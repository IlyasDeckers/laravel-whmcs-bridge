<?php
namespace App\Phase\Cpanel;

use App\Http\Controllers\Traits\Actions;
use App\Phase\Cpanel\Softaculous\Softaculous;
use Exception;
use Cache;
use Whmcs;
use Auth;
use Gate;
use Api;

class Cpanel
{
    use Actions;

    /**
     * The provided arguments
     * 
     * @var array
     */
    protected $arguments;

    /**
     * The WHMCS client id
     * 
     * @var [type]
     */
    protected $clientId;

    /**
     * The function name split to an array
     * 
     * @var array
     */
    protected $nameSplit;

    /**
     * The function name that is called
     * 
     * @var string
     */
    protected $functionName;

    /**
     * Deafault Cache Time
     * 
     * @var integer
     */
    protected $cacheTime = 5;

    /**
     * Cache on/off
     * 
     * @var boolean
     */
    protected $cache = false;

    /**
     * Display extra error messages for debugging
     * 
     * @var boolean
     */
    protected $debug;

    /**
     * Cpanel API response
     * 
     * @var object
     */
    protected $response;

    public function __construct()
    {
        $this->debug = env('APP_DEBUG', false);
    }

    /**
     * Something magic
     * 
     * @param  sting $name      
     * @param  array $arguments 
     * @return object            
     */
    public function __call($name, $arguments)
    {
        $this->prepare($name, $arguments);

        if($this->checkCache()){
            return $this->response;
        }
 
        try{
            $this->response = Api::respondSuccess(
                $this->send(
                    $this->arguments, 
                    $this->getClass($this->nameSplit), 
                    $this->name
                )
            );

            $this->putInCache();

        }catch(Exception $e){
            $data = (object) ['message' => 'Something went wrong'];
            
            if($this->debug){
                $data->debug = $e->getMessage();
            }

            $this->response = Api::respondNotFound($data);
        }

        return $this->response;
    }

    private function prepare($name, $arguments)
    {
        $this->getArguments($arguments);
        $this->setFunction($name);
        $this->getClientId();
        $this->validateAccount();
        $this->setCache();
    }

    private function getArguments($arguments)
    {
        if(isset($arguments[0]['hostname']) || isset($arguments[0]['username']))
        {
            $arguments = $arguments[0];
        }

        $this->arguments = $arguments;
    }

    private function setFunction($name)
    {
        $this->name = $name;
        $this->nameSplit = preg_split('/(?=\p{Lu})/u', $name);
    }

    private function setCache()
    {
        if(isset($this->arguments['cache']))
        {   
            $this->cache = $this->arguments['cache'];
        }

        $this->flushCache();
    }

    private function checkCache()
    {
        // If is already present in cache
        if(Cache::tags(['cpanel', $this->name . $this->arguments['username']])->get($this->name . '_' . Auth::user()->id))
        { 
            $this->response = Cache::tags(['cpanel', $this->name . $this->arguments['username']])
                ->get($this->name . '_' . Auth::user()->id);

            return true;
        }
    }

    private function putInCache()
    {
        Cache::tags([
            'cpanel', $this->name . $this->arguments['username']
        ])->put(
            $this->name . '_' . Auth::user()->id, 
            $this->response, 
            $this->cacheTime
        );
    }

    private function flushCache()
    {
        if(!$this->cache)
        {
            Cache::tags(['cpanel', $this->name . $this->arguments['username']])
                ->flush();
        }

        if($this->nameSplit[0] == 'create' || $this->nameSplit[0] == 'delete' || $this->nameSplit[0] == 'add' || $this->nameSplit[0] == 'install')
        {
            Cache::tags(['cpanel', $this->name . $this->arguments['username']])
                ->flush();
        }
    }

    private function getClientId()
    {
        try{
            $this->clientId = $this->search(Whmcs::getProducts(), 'username', $this->arguments['username'])[0]['clientid'];
        }catch(Exception $e){
            abort(500);
        }
    }

    private function validateAccount()
    {
        $this->validateUsername();
        $this->validateHostname();

        if(Gate::denies('owns-data', $this->clientId))
        {
            abort(404);
        }
    }

    private function validateUsername()
    {
        if(!isset($this->arguments['username']))
        {
            dd(Api::respondInternalError('Account username is a required parameter'));
        }
    }

    private function validateHostname()
    {
        if(!isset($this->arguments['hostname']))
        {
            dd(Api::respondInternalError('Server hostname is a required parameter'));
        }
    }

    /**
     * Execute
     * 
     * @param  array $arguments
     * @param  string $className    
     * @param  string $functionName 
     * @return object              
     */
    private function send($arguments, $className, $functionName)
    {
        if (!class_exists($className)) {
            throw new Exception('The class ' . $className . ' does not exist.');
        }

        try{

            $data = new $className($arguments);
            return $data->$functionName();

        }catch(Exception $e){

            throw new Exception($e);

        } 
    }

    /**
     * Get the class name
     * 
     * @param  array $name 
     * @return string      
     */
    private function getClass($name)
    {
        return 'App\\Phase\\Cpanel\\' . $this->folder($name) . '\\' . $this->file($name);
    }

    private function folder($name)
    {
        if(in_array("Addon", $name) || in_array("Sub", $name)){ return  'Domains\\' . $name[1] .'Domains';}
        if(in_array("Manager", $name) || in_array("Admin", $name)){ return  'SSO';}
        if(in_array("Database", $name) || in_array("Databases", $name)){ return  'Mysql'; }
        if(in_array("Application", $name) || in_array("Applications", $name)){ return  'Softaculous'; }
        if(in_array("Dns", $name)){ return  'Domains\\Dns'; }

        return $name[1];

    }

    private function file($name)
    {
        if(in_array("Addon", $name)){ return  'AddonDomains'; }
        if(in_array("Sub", $name)){ return  'SubDomains'; }
        if(in_array("Manager", $name) || in_array("Admin", $name)){ return  'Session';}
        if(in_array("Database", $name) || in_array("Databases", $name)){ return  'Mysql'; }
        if(in_array("Application", $name) || in_array("Applications", $name)){ return  'Softaculous'; }
        if(in_array("Dns", $name)){ return  'Dns'; }
        
        return $name[1];

    }

    public function listApplicationsDashboard($category = null)
    {
        $d = new Softaculous;
        $d = $d->listDashboard($category);

        if($d == false){
            return Api::respondInternalError($d);
        }

        return Api::respondSuccess($d);
    }

    public function getAppFields()
    {
        $d = new Softaculous;
        $d = $d->getFields();

        return Api::respondSuccess($d);
    }
}