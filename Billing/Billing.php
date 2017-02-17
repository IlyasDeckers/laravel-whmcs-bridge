<?php 
namespace App\Phase\Billing;

use Session;
use Mollie;
use Whmcs;
use Auth;
use Api;

class Billing 
{
	public function getInvoices($status = null)
    {
        $invoices = new Invoice();   
        return Api::respondSuccess($invoices->getInvoices($status));

    }

    public function getInvoice($id)
    {
        $invoice = new Invoice();
        return Api::respondSuccess($invoice->getInvoice($id));
    }

    public function getInvoiceItems($id)
    {
        $invoice = new Invoice();
        return Api::respondSuccess($invoice->getItems($id));
    }

    public function payInvoice($invoiceId)
    {
        $invoice = new Payment();
        return Api::respondSuccess($invoice->pay($invoiceId));
    }

    public function mollieAnswer($request)
    {
        $invoice = new Payment();
        return Api::respondSuccess($invoice->webhookRecieved($request));
    }

    public function addFunds()
    {
        //
    }

    public function getFunds()
    {
        //
    }
}