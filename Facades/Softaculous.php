<?php
namespace App\Phase\Facades;

use Illuminate\Support\Facades\Facade;

class Softaculous extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'softaculous';
	}
}