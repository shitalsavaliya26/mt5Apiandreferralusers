<?php

namespace App\Models;

use App\User;
use Eloquent as Model;

/**
 * Class TicketMessage
 * @package App\Models
 * @version January 7, 2020, 6:53 am UTC
 *
 * @property integer user_id
 * @property integer support_id
 * @property string messages
 */
class TicketMessage extends Model
{
    public $table = 'ticket_messages';

    public $fillable = [
        'id',
        'user_id',
        'support_id',
        'messages','reply_from',
    ];

    public function support()
    {
        return $this->belongsTo(Support::class, 'support_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ticketAttachments()
    {
        return $this->hasMany(TicketAttachment::class, 'ticket_id');
    }
}
