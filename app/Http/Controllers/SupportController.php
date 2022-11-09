<?php

namespace App\Http\Controllers;

use App\Models\Support;
use App\Models\TicketAttachment;
use App\Models\TicketMessage;
use App\Models\TicketTitle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Response;

/**
 * Class SupportController
 * @package App\Http\Controllers
 */
class SupportController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function supports(Request $request)
    {
	   $ticketStatus = null;       
        $data = $request->all();
        $items = $request->items ?? 50;

        $query = Support::with('titles');
	    $query2 = Support::with('titles');
        $openTicket = Support::where('user_id', auth::user()->id)->where('status', 0);
        $closeTicket = Support::where('user_id', auth::user()->id)->where('status', 1);

        $searchedDate = '';
        
	   if (!empty($request->start_date) && !empty($request->end_date)) {

            $startDate = new \DateTime($request->start_date);
            $startDate = $startDate->format('Y-m-d');

            $endDate = new \DateTime($request->end_date);
            $endDate = $endDate->format('Y-m-d');

            if ($startDate == $endDate) {
                $query = $query->whereDate('created_at', $startDate);
                $query2 = $query2->whereDate('created_at', $startDate);
            } else {
                $query = $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
                $query2 = $query2->whereBetween('created_at', [$request->start_date, $request->end_date]);
            }

            $startdate = Carbon::parse($request->start_date)->format('m/d/Y');
            $enddate = Carbon::parse($request->end_date)->format('m/d/Y');
            $searchedDate = $startdate . ' - ' . $enddate;
            $openTicket = $openTicket->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $closeTicket = $closeTicket->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if(isset($request->tickets_status)){
        
            if ($request->tickets_status == 0) {
                $query = $query->where('status',0);
                $query2 = $query2->where('status',0);
                $ticketStatus = 0;
            } 
            if ($request->tickets_status == 1) {
                $query = $query->where('status',1);
                $query2 = $query2->where('status',1);
                $ticketStatus = 1;
            }

        }
        $openTicket = $openTicket->count();
        $closeTicket = $closeTicket->count();


        if (isset($request->status)) {
            $status = $request->status;
            $query = $query->where('status', $status);
            $ticketStatus = $request->status;
        }
        $supports = $query->orderBy('id','desc')->where('user_id', auth::user()->id)->paginate($items)->appends($request->except('_token'));
        $ticketTitles = TicketTitle::get()->pluck('title', 'id');

        $totalTickets = $query2->where('user_id', auth::user()->id)->paginate($items)->appends($request->except('_token'));

        
        if($request->ajax()){

            $html = view('supports.support', compact('supports', 'openTicket', 'closeTicket', 'searchedDate', 'ticketTitles','totalTickets','ticketStatus','data'))->withItems($items)->render();   
            return response()->json([
                'data' => $supports,
                'html'=>$html,
                'status' => true
            ]);         
        }
        

        return view('supports.support', compact('supports', 'openTicket', 'closeTicket', 'searchedDate', 'ticketTitles','totalTickets','ticketStatus','data'))
            ->withItems($items);
    }

    public function addSupport(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'title_id' => 'required',
            'messages' => 'required'
        ]);
        $input['user_id'] = auth::user()->id;

        $support = Support::create($input);

        $ticketMessage = TicketMessage::create([
            'messages' => $input['messages'],
            'support_id' => $support->id,
            'user_id' => $input['user_id'],
        ]);

        if ($request->hasFile('attachments')) {
            $files = $request->file('attachments');
            foreach ($files as $file) {
                $input['attachment'] = $file->getClientOriginalName();
                $file->storeAs('supports_attachments', $file->getClientOriginalName());

                $ticketAttachment = new TicketAttachment([
                    'attachment' => $input['attachment'],
                    'ticket_id' => $ticketMessage->id
                ]);

                $ticketMessage->ticketAttachments()->save($ticketAttachment);
            }
        }

        return redirect()->back()->with('message', 'Ticket has been created.');
    }

    public function updateTicketStatus(Request $request)
    {
        if (!empty($request)) {
            $supportId = $request->support_id;

            Support::where('user_id', auth::user()->id)
                ->where('id', $supportId)
                ->update(['status' => 1]);

        }

        return response()->json(['success' => true, 'message' => 'updated successfully']);
    }

    public function replyTicketsView($supportId, Request $request)
    {
        $supportId = Crypt::decrypt($supportId);

        $ticketTitle = Support::with('titles')->where('id', $supportId)->first();
        TicketMessage::where(['reply_from'=>'admin'])->where('support_id', $supportId)->update(['is_read'=>'1']);
        $ticketMessage = TicketMessage::with(['support', 'user', 'ticketAttachments'])->where('support_id', $supportId)->get();

        return view('supports.reply_ticket', compact('ticketMessage', 'ticketTitle'));
    }

    public function ticketReply(Request $request)
    {
	//return storage_path();

        if (!empty($request->all())) {
            $request->validate([
                'messages' => 'required'
            ]);

            $input = $request->all();

            $ticketMessage = TicketMessage::create([
                'user_id' => auth::user()->id,
                'support_id' => $input['support_id'],
                'messages' => $input['messages'],
            ]);

            if ($request->hasFile('attachments')) {
                $files = $request->file('attachments');
                foreach ($files as $file) {
                    $input['attachment'] = $file->getClientOriginalName();
                    $file->storeAs('uploads/supports_attachments', time().'-'.$input['attachment']);

                    $ticketAttachment = new TicketAttachment([
                        'attachment' => time().'-'.$input['attachment'],
                        'ticket_id' => $ticketMessage->id
                    ]);

                    $ticketMessage->ticketAttachments()->save($ticketAttachment);
                }
            }
        }

        return redirect()->back()->with('message', 'sent successfully');
    }
}
