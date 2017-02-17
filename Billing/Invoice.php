<?php 
namespace App\Phase\Billing;

use DB;
use Auth;
use Gate;
use Cache;
Use Whmcs;
use Exception;
use App\Http\Controllers\Traits\Actions;

class Invoice extends Billing 
{
    use Actions;

    /**
     * Get the invoices, if not present in cache store it.
     *
     * @var $id
     * @var $status
     * @return $invoices
     */
	public function getInvoices($status = null)
	{

        $id = Auth::user()->wid;


        if (isset($status)){

            $data =  DB::connection('mysql_whmcs')
                ->table('tblinvoices')
                ->where('userid', $id)
                ->where('status', ucfirst($status)) 
                ->get();

        } else {

            $data = DB::connection('mysql_whmcs')
                ->table('tblinvoices')
                ->where('userid', $id)
                ->get();

        }

        return $data;
	}

	public function getInvoice($invoiceid)
	{
        $wid = Auth::user()->wid;

        $data = DB::connection('mysql_whmcs')
            ->table('tblinvoices')
            ->where('id', $invoiceid)
            ->first();


        if (Gate::denies('owns-data', $data->userid)){
            abort(401);
        }

        return $data;

	}

    public function getItems($invoiceId)
    {
        $wid = Auth::user()->wid;

        $data = DB::connection('mysql_whmcs')
            ->table('tblinvoiceitems')
            ->where('invoiceid', $invoiceId)
            ->get();

        return $data;

    }
}