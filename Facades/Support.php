<?php
namespace App\Phase\Facades;

use Illuminate\Support\Facades\Facade;

class Support extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'support';
	}
}