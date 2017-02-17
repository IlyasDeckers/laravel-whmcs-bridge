<?php
namespace App\Phase\Notifications;

use Illuminate\Support\ServiceProvider;

class NotificationsServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('notifications', 'App\Phase\Notifications\Notifications');
	}
}