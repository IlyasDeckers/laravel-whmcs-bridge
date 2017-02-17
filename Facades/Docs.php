<?php
namespace App\Phase\Facades;

use Illuminate\Support\Facades\Facade;

class Docs extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'docs';
	}
}