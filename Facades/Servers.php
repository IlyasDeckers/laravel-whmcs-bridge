<?php
namespace App\Phase\Facades;

use Illuminate\Support\Facades\Facade;

class Servers extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'servers';
	}
}