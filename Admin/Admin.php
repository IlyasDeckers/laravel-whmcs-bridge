	<?php
namespace App\Phase\Admin;

use Whmcs;

class Admin
{
	public function getAutomationLog()
	{
		return Whmcs::execute('GetAutomationLog');
	}

	public function GetActivityLog()
	{
		return Whmcs::execute('GetActivityLog');
	}
}