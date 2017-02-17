<?php
namespace App\Phase\Facades;

use Illuminate\Support\Facades\Facade;

class Cpanel extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'cpanel';
	}
}