<?php
namespace App\Phase\Notifications;

use Billing;
/*use App\Phase\Notifications\InvoiceDue;*/

class InvoiceNotification extends Notifications
{
	/*public function invoicesDue()
	{
		$invoices = Billing::getInvoices('Unpaid');

		if ($invoices['totalresults'] == '0') {
			return [];
		}

		$total = array_column($invoices['invoices']['invoice'], 'total');
		$total = array_sum($total);

		return Notification::message(
			'Onbetaalde factuur', 
			'/invoices', 
			trans('messages.openinvoice'), 
			'caution',
			trans('messages.openinvoice') . '<br>Totaal: <b>€' . $total .'</b>',
			'warning',
			$total
		);
	}*/

	public function invoicesDue($data)
	{
		return 'success';
		$invoices = Billing::getInvoices('Unpaid');

		if ($invoices['totalresults'] != '0') {

			dd($invoices);

			$invoice = array(

			);


			Auth::user()->notify(new \App\Notifications\InvoiceDue($invoice));
		}

	}
}