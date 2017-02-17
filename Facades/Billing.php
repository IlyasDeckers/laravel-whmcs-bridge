<?php
namespace App\Phase\Facades;

use Illuminate\Support\Facades\Facade;

class Billing extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'billing';
	}
}