<?php 
namespace App\Phase\Support;

use GrahamCampbell\Markdown\Facades\Markdown;
use Whmcs;
use Cache;
use Auth;
use Api;
use DB;

class Support 
{
    /**
     * Get all the logged in user's tickets
     * 
     * @param  string $status (Open, Closed, Answered, Customer-Reply) - not required
     * @return object 
     */
	public function getTickets($status = null)
    {
        if (!isset($status)){
    		$tickets =  DB::connection('mysql_whmcs')
                ->table('tbltickets')
                ->where('userid', Auth::user()->wid)
                ->get();
        }

        if (isset($status)){
            $tickets =  DB::connection('mysql_whmcs')
                ->table('tbltickets')
                ->where('userid', Auth::user()->wid)
                ->where('status', ucfirst($status))
                ->get();
        }

        if (isset($tickets)){
            $tickets = Api::respondSuccess($tickets);
        }

    	return $tickets;
    }

    /**
     * Get the tickets for the dashboard
     * 
     * @return object
     */
	public function getTicketsHome()
	{
        $tickets =  DB::connection('mysql_whmcs')
            ->table('tbltickets')
            ->where('userid', Auth::user()->wid)
            ->take(3)
            ->get();

        return Api::respondSuccess($tickets);
	}

    /**
     * Get a single ticket
     * 
     * @param  int $ticketId 
     * @return object
     */
    public function getTicket($ticketId)
    {
        $ticket =  DB::connection('mysql_whmcs')
            ->table('tbltickets')
            ->where('id', $ticketId)
            ->first();

        return Api::respondSuccess($ticket);
    }

    /**
     * Get ticket replies
     * 
     * @param  int $ticketId 
     * @return object         
     */
    public function getTicketReply($ticketId)
    {
        $reply = DB::connection('mysql_whmcs')
            ->table('tblticketreplies')
            ->where('tid', $ticketId)
            ->orderBy('date', 'desc')
            ->get();

        if($reply == []){
            $reply = null;
        }

        return Api::respondSuccess($reply);
    }

    /**
     * Answer a ticket
     * 
     * @param  array $r        
     * @param  int $ticketId 
     * @return object
     */
	public function answerTicket($r, $ticketId)
	{
        $message = $r['message'];

		$ticket = Whmcs::execute('AddTicketReply', array(
            'ticketid' => $ticketId,
            'message' => $message,
            'clientid' => Auth::user()->wid,
            'useMarkdown' => 'false',
        ));

        return $ticket;
	}

    /**
     * Open a support ticket
     * @param  array $r
     * @return array
     */
    public function openTicket($r)
    {
        $message = $r['message'];

        $ticket = Whmcs::execute('OpenTicket', array(
            'clientid' => Auth::user()->wid,
            'deptid' => '1',
            'subject' => $r['subject'],
            'message' => $message
        ));

        return $ticket;
    }
}