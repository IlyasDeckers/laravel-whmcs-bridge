<?php
namespace App\Phase\Cpanel\Softaculous;

trait GetApplicationFields 
{
	public function getApplicationFields()
	{
		$name = $this->data['application'];
		if($name == "Vue.js"){
			$name = 'vue';
		}
		
		return $this->$name();
	}

	private function WordPress()
	{
		return [
			'sitename' => [
				'name' => trans('messages.sitename'),
				'type' => 'text'
			], 

			'sitedescription' => [
				'name' => trans('messages.sitedescription'),
				'type' => 'text'
			], 

			'multisite' => [
				'name' => trans('messages.multisite'),
				'type' => 'select',
				'values' => [
					trans('messages.no'),
					trans('messages.yes')
				],
			], 

			'adminusername' => [
				'name' => trans('messages.adminusername'),
				'type' => 'text'
			], 

			'adminpassword' => [
				'name' => trans('messages.adminpassword'),
				'type' => 'password'
			], 

			'sitelanguage' => [
				'name' => trans('messages.language'),
				'type' => 'select',
				'values' => [
					'English',
					'Nederlands'
				],
			],
		];
	}

	private function Magento()
	{
		return [
			'sitename' => [
				'name' => trans('messages.sitename'),
				'type' => 'text'
			], 

			'adminusername' => [
				'name' => trans('messages.adminusername'),
				'type' => 'text'
			], 

			'adminpassword' => [
				'name' => trans('messages.adminpassword'),
				'type' => 'password'
			], 

			'sitelanguage' => [
				'name' => trans('messages.language'),
				'type' => 'select',
				'values' => [
					'English',
					'Nederlands'
				],
			],
		];
	}

	private function Whmcs()
	{
		return [
			'sitename' => [
				'name' => trans('messages.sitename'),
				'type' => 'text'
			], 

			'adminusername' => [
				'name' => trans('messages.adminusername'),
				'type' => 'text'
			], 

			'adminpassword' => [
				'name' => trans('messages.adminpassword'),
				'type' => 'password'
			], 

			'license_key' => [
				'name' => trans('messages.validlicense'),
				'type' => 'text'
			], 

			'sitelanguage' => [
				'name' => trans('messages.language'),
				'type' => 'select',
				'values' => [
					'English',
					'Nederlands'
				],
			],
		];
	}

	private function Laravel()
	{
		return [];
	}

	private function Codeigniter()
	{
		return [];
	}

	private function vue()
	{
		return [];
	}

	public function __call($name, $arguments)
	{
		return [
			'sitename' => [
				'name' => trans('messages.sitename'),
				'type' => 'text'
			], 

			'adminusername' => [
				'name' => trans('messages.adminusername'),
				'type' => 'text'
			], 

			'adminpassword' => [
				'name' => trans('messages.adminpassword'),
				'type' => 'password'
			], 

			'sitelanguage' => [
				'name' => trans('messages.language'),
				'type' => 'select',
				'values' => [
					'English',
					'Nederlands'
				],
			],
		];
	}
}