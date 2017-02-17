<?php
namespace App\Phase\Servers;

use Illuminate\Support\ServiceProvider;

class ServerServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('servers', 'App\Phase\Servers\Servers');
	}
}