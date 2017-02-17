<?php 
namespace App\Phase\Whmcs;

use App\Http\Controllers\Traits\Actions;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ParseException;
use GuzzleHttp\Client;
use Exception;
use App\User;
use Config;
use Cache;
use Auth;
use Gate;
use Api;
use DB;

class Whmcs 
{
    use Actions;

    public function execute($action, $params=[])
    {
        // Initiate
        $params['username']     = config('whmcs.username');
        $params['responsetype'] = config('whmcs.responsetype','json');
        $params['action']       = $action; 

        $auth_type = config('whmcs.auth_type', 'password');

        switch($auth_type)
        {
            case 'api':
            if(false === Config::has('whmcs.password') || '' === config('whmcs.password'))
                throw new Exception("Please provide api key for authentication");
            $params['accesskey'] = config('whmcs.password');
            break;
            case 'password':
            if(false === Config::has('whmcs.password') || '' === config('whmcs.password'))
                throw new Exception("Please provide username password for authentication");
            $params['password']     = md5(config('whmcs.password'));
            break;
        }

        $url = config('whmcs.url');
        // unset url
        unset($params['url']);
        $client = new Client(['defaults' => ['headers' => ['User-Agent' => null]]]);
        try
        {
            $response = $client->post($url, ['form_params' => $params,'timeout' => 1200,'connect_timeout' => 10]);

            try
            {
                return $this->processResponse(json_decode($response->getBody()->getContents(), true));
            }
            catch(ParseException $e)
            {
                return $this->processResponse($response->xml());
            }
        }
        catch(ClientException $e)
        {
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);
            throw new Exception($response['message']);
        }

    }

    public function processResponse($response)
    {
        if(isset($response['result']) && 'error' === $response['result']
            || isset($response['status']) && 'error' === $response['status'] )
            throw new Exception("WHMCS Response Error : ".$response['message']);
        return json_decode(json_encode($response),'array'===config('whmcs.response', 'object'));
    }

	/**
     * Get the Whmcs user data.
     *
     * @var array
     */
    public function getUser()
    {
        $user = DB::connection('mysql_whmcs')
            ->table('tblclients')
            ->where('id', Auth::user()->wid)
            ->first();

        $btw = DB::connection('mysql_whmcs')
            ->table('tblcustomfieldsvalues')
            ->where('relid', Auth::user()->wid)
            ->first();

        $user->btw = $btw->value;

        unset( $user->{'password'} );
        unset( $user->{'securityqans'} );
        unset( $user->{'uuid'} );

        Cache::put('UserInfo_' . Auth::user()->wid, $user, 30);


        if (Gate::denies('owns-data', $user->id)){
            abort(401);
        }

        return Api::respondSuccess($user);
    }

    public function getUserByEmail($email)
    {
        return Whmcs::execute('getclientsdetails', array('email' => $email));
    }

    /**
     * Migrate user from old client
     * if he exists in whmcs
     *
     * @var $request
     */
    public function preAuthCheck($r)
    {
    	$data = $this->getUserByEmail($r['email']);

        if ($data['result'] == 'success') {
            $laravelUser = User::where('email', $r['email'])->first(); 
        }

        if (!isset($laravelUser)) {
            $this->validateLogin($r);
            $this->create($data, $r);
        }
    }

    public function create($data, $r)
    {
        return User::create([
           'firstname' => $data['firstname'],
           'lastname' => $data['lastname'],
           'email' => $data['email'],
           'wid' => $data['userid'],
           'language' => $data['language'],
           'password' => bcrypt($r['password']),
           'color' => 'gray'
        ]);
    }

    public function register($data)
    {
        return Whmcs::execute('addclient', array(
            'skipvalidation' => true,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => $data['password'],
        ))['clientid'];
    }

    public function validateLogin($r)
    {
        try {
            return Whmcs::execute('validatelogin', array(
                'email' => $r['email'],
                'password2' => $r['password']
            ));
        } catch (Exception $e) {

        }
    }

    public function whmcs($action, $values)
    {
        return Whmcs::execute($action, $values);
    }

    public function getProducts($type = null, $value = null)
    {
        $wid = Auth::user()->wid;
        $data = $this->whmcs('getclientsproducts', array('clientid' => $wid));
        
        if (isset($data['products']['product'])) {
            $arr = $data['products']['product'];
            if ($type){
                $data = $this->search($arr, $type, $value);
            }

            $data = $this->combineProducts($data);

            return $data;
        }

        return  [];
    }

    public function getProduct($pid)
    {   try{
            $data = $this->whmcs('getclientsproducts', array('serviceid' => $pid))['products']['product'][0];
        }catch(Exception $e){
            abort(404);
        }

        if($data['status'] == 'Suspended'){
            abort(506);
        }

        return $data;
    }

    public function combineProducts($arr)
    {
        return array_merge_recursive(
            $this->search($arr, 'status', 'Active'), 
            $this->search($arr, 'status', 'Suspended')
        );
    }

    public function getDomains($domainid = null)
    {
        return $this->whmcs('getclientsdomains', array('clientid' => Auth::user()->wid, 'domainid' => $domainid));
        //sort by active, terminated,...
    }

    // using magic method
    public function __call($action, $params)
    {
        return $this->execute($action, $params);
    }

}