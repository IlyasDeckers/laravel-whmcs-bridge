<?php 
namespace App\Phase\Company;

use Whmcs;
use Cache;

class Company 
{
	public function get($type = null)
	{
		return $this->companyInfo($type);
	}

	public function infoToDb()
	{	
		$data = $this->api();
		$company = new \App\Company;

		if ($company->first()) {
			$company = $company->first();
		}
		
		$company->logo = $data['data']['logo'];
		$company->companyname = $data['data']['companyname'];
		$company->email = $data['data']['email'];
		$company->tos = $data['data']['tos'];
		$company->address = $data['data']['address'];
		$company->save();

		$message = array(
			'message' 	=> 'success',
			'code'		=> 200,
			'data' 		=> $this->companyInfo()
		);

	}

	private function companyInfo($type = null)
	{
		if (!Cache::has('companyinfo'))
		{
			$company = new \App\Company;
			$company = $company->first();
			Cache::put('companyinfo', $company, 60);
		}

		$company = Cache::get('companyinfo');

		if ($type) {
			$company = $company->get([$type])[0][$type];
			return $company;
		}

		return array(
			'message' 	=> 'success',
			'code'		=> 200,
			'data' 		=> $company
		);
	}

	private function api()
	{
		try {
			return Whmcs::execute('getcompanyinfo');
		} catch (Exception $e) {
			return '';
		}
	}
}