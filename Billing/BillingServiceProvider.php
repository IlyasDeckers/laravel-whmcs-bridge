<?php
namespace App\Phase\Billing;

use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('billing', 'App\Phase\Billing\Billing');
	}
}