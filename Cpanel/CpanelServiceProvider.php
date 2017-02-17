<?php
namespace App\Phase\Cpanel;

use Illuminate\Support\ServiceProvider;

class CpanelServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('cpanel', 'App\Phase\Cpanel\Cpanel');
	}
}