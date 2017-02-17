<?php 
namespace App\Phase\Billing;

use Mollie;
use Whmcs;
use Cache;
use Auth;
use Mail;
use App;

class Payment extends Billing
{
	protected $locale;

	protected $invoice;

	protected $payment;

	protected $webhook;

	public function __construct()
	{
		$this->locale = App::getLocale();
	}

	public function pay($invoiceid)
    {
        $this->invoice = $this->getInvoice($invoiceid)->data;

        $payment = \Mollie::api()->payments()->create([
            "amount"      => $this->invoice->total,
            "description" => 'Factuur - ' . $this->invoice->invoicenum,
            "redirectUrl" => \URL::previous(),
            "webhookUrl"  => "https://phasehosting.io/webhooks/payment/recieve",
            'locale'      => $this->locale . '_' . mb_strtoupper($this->locale)
        ]);

        $store = [
    		'invoiceid' => $this->invoice->id, 
    		'paymentid' =>  $payment->id, 
    		'userid' => Auth::user()->id
    	];

        Cache::put('payment' . $payment->id, $store, 15);

        header("location:" . $payment->links->paymentUrl);
        die;
    }

    public function webhookRecieved($request)
    {
    	$this->webhook = Cache::get('payment' . $request->id);

    	Auth::loginUsingId($this->webhook['userid'], true);
    			
    	if(!$this->webhook){
			dd($error);
		}


        if($request->id == $this->webhook['paymentid'])
        {
        	$this->payment = Mollie::api()->payments()->get($this->webhook['paymentid']);

        	$this->isPaid();
        }
    }

    private function isPaid()
    {
    	if ($this->payment->isPaid())
        {
            $this->invoice = $this->getInvoice($this->webhook['invoiceid'])->data;
            $this->addInvoicePayment();

            Cache::tags(['payment' . $this->webhook['invoiceid']])->put('success', 'payment successfull!', 15);

            return 'Betaling Toegevoegd';
        }
    }

    private function addInvoicePayment()
    {
        Whmcs::execute('AddInvoicePayment', [
            'invoiceid' => $this->webhook['invoiceid'],
            'transid' => $this->webhook['paymentid'],
            'gateway' => 'mollie' . $this->payment->method,
            'date' => date("Y-m-d H:i:s")
        ]);
    }
}