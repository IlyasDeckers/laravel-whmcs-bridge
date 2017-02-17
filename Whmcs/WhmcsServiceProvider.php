<?php
namespace App\Phase\Whmcs;

use Illuminate\Support\ServiceProvider;

class WhmcsServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('whmcs', 'App\Phase\Whmcs\Whmcs');
	}
}