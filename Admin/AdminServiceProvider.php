<?php
namespace App\Phase\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('admin', 'App\Phase\Admin\Admin');
	}
}