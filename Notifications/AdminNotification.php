<?php
namespace App\Phase\Notifications;

use DB;
use Cache;

class AdminNotification extends Notifications
{
	public function getOrders()
	{
		$orders = Cache::remember('menu_docs', 10, function()
		{
		    return DB::connection('mysql_whmcs')
	            ->table('tblorders')
	            ->where('status', 'Active')
	            ->get();
		});

		return $orders;
	}
}