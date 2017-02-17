<?php
namespace App\Phase\Docs;

use Illuminate\Support\ServiceProvider;

class DocsServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('docs', 'App\Phase\Docs\Docs');
	}
}