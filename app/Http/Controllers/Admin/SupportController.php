<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Models\Support;
use App\Models\TicketAttachment;
use App\Models\TicketMessage;
use App\Models\TicketTitle;
use Illuminate\Http\Request;
use Response;

/**
 * Class SupportController
 * @package App\Http\Controllers\Admin
 */
class SupportController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function supports(Request $request)
    {
        $query = Support::with('users', 'titles');

        if (isset($request->status)) {
            $status = $request->status;

            $status = $status == 3 ? 0 : $status;
            $query = $query->where('status', $status);

        }
        $openTicket = Support::where('status', 0)->whereHas('users')->count();
        $closeTicket = Support::where('status', 1)->whereHas('users')->count();

        $supports = $query->whereHas('users')->orderBy('id','desc')->paginate(4);

        return view('admin.supports.support', compact('supports', 'openTicket', 'closeTicket'));
    }

    public function viewAllTickets(Request $request)
    {
        $ticketTitles = TicketTitle::get()->pluck('title', 'id');

        $supports = Support::with(['users', 'titles', 'supportMessage.ticketAttachments'])->whereHas('users')->orderBy('id','desc')->paginate(15);

        return view('admin.supports.view_tickets', compact('supports', 'ticketTitles'));
    }

    public function updateTicketStatus($id)
    {
        Support::where('id', $id)->update(['status' => 1]);

        return redirect('/avanya-vip-portal/view-all-tickets')->with('message', 'Ticket closed successfully.');
    }

    public function replyTicketsView($supportId, Request $request)
    {
        $ticketTitle = Support::with('titles')->where('id', $supportId)->first();
        TicketMessage::where(['reply_from'=>'user'])->where('support_id', $supportId)->update(['is_read'=>'1']);
        $ticketMessage = TicketMessage::with(['support', 'user', 'ticketAttachments'])->where('support_id', $supportId)->get();
	
        return view('admin.supports.reply_ticket', compact('ticketMessage', 'ticketTitle'));
    }

    public function replyTicketsView2($supportId, Request $request)
    {
        return redirect('/avanya-vip-portal/reply-tickets/'.$supportId)->with('reply_success', 'Successfully send');
    }	

    public function adminTicketReply(Request $request)
    {
        if (!empty($request->all())) {

            $request->validate([
                'messages' => 'required'
            ]);

            $input = $request->all();

            $ticketMessage = TicketMessage::create([
                'user_id' => 'admin',
                'support_id' => $input['support_id'],
                'messages' => $input['messages'],
                'reply_from' => 'admin',
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

        }

        return response()->json([
            'success' => true,

        ], 200);
    }
}
