<?php
namespace App\Phase\Notifications;

use Api;
use Billing;
use Support;

class Notifications
{
	public function createNotification($type, array $data)
	{
		
	}


	public function get()
	{
		$notifications = array_filter(
	      array(
	        'invoices' => $this->invoicesDue(),
	        'tickets' => $this->support(),
	      )
	    );

	    return Api::respondSuccess($notifications);
	}

	public function invoicesDue()
	{
		$invoices = Billing::getInvoices('Unpaid');
    
	    if($invoices->totalresults){
	      $total = (array) $invoices->data;
	      /*dd($total);*/
	      $total = array_sum(array_column($total, 'total'));
	      return $this->message(
	        trans('messages.OpenInvoices'), 
	        route('showInvoices'), 
	        trans('messages.viewInvoice'), 
	        'caution',
	        trans('messages.viewInvoice') . trans('messages.total') . $total .'</b>',
	        'warning',
	        $total
	      );
	    }
	}

	private function support()
	{
		if(Support::gettickets('Answered')->data != []) {
			return $this->message(
				'Je vraag is beantwoord', 
				route('showTickets'), 
				trans('messages.openticket'),
				'compose',
				'Een Supportmedewerker heeft op je ticket geantwoord',
				'primary'
			);
		}
	}

	private function message($title, $url, $message, $image, $homemessage, $color, $total = null)
	{
		return array(
		  'title'   	=> $title,
		  'url'     	=> $url,
		  'message' 	=> $message,
		  'total'   	=> $total,
		  'image'   	=> $image,
		  'color'   	=> $color,
		  'HomeMessage' => $homemessage
		);
	}
}

