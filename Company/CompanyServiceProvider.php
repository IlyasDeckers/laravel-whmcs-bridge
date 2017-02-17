<?php
namespace App\Phase\Company;

use Illuminate\Support\ServiceProvider;

class CompanyServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('company', 'App\Phase\Company\Company');
	}
}