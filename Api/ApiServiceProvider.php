<?php
namespace App\Phase\Api;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('api', 'App\Phase\Api\Api');
	}
}