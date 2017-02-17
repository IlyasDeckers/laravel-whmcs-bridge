<?php 
namespace App\Phase\Api;

use App\User;
use Auth;
use Response;

class Api
{
	/**
     * Create a new personal access token for the user.
     *
     * @param  Request  $request
     * @return PersonalAccessTokenResult
     */

	public function getTokens($name = null)
	{
		return User::find(Auth::user()->id)->tokens->load('client')->filter(function ($token) {
            return $token->client->personal_access_client && ! $token->revoked;
        })->values();
	}

	/**
     * Create a new personal access token for the user.
     *
     * @param  Request  $request
     * @return PersonalAccessTokenResult
     */
	public function createToken($name, $scopes = null)
	{
		return User::find(Auth::user()->id)->createToken($name)->accessToken;
	}

	/**
     * Delete the given token.
     *
     * @param  Request  $request
     * @param  string  $tokenId
     * @return Response
     */
	public function deleteToken($tokenId)
	{
		User::find(Auth::user()->id)->tokens->find($tokenId)->revoke();
	}

    /**
     * 200 Success Response
     *
     * @var $data
     * @return $object
     */
    public function respondSuccess($data)
    {
        $response = [
            "result" => "success", 
            "code" => 200,
            "totalresults" => count($data),
            "data" => $data
        ];

        return Response::json($response)->getData();
    }

    /**
     * 404 Not Found Response
     *
     * @var $data
     * @return $object
     */
    public function respondNotFound($data)
    {
        $response = [
            'result' => 'error', 
            'code' => 404,
            'message' => 'Not found',
            "data" => $data
        ];

        return Response::json($response)->getData();
    }

    /**
     * 500 Internal Serve Error Response
     *
     * @var $data
     * @return $object
     */
    public function respondInternalError($data)
    {
        $response = [
            'result' => 'error', 
            'code' => 500,
            'message' => 'Internal Server Error',
            "data" => $data
        ];

        return Response::json($response)->getData();
    }
}