<?php
namespace App\Phase\Support;

use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('support', 'App\Phase\Support\Support');
	}
}