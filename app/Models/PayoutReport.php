<?php

namespace App\Models;

use App\User;
use Eloquent as Model;

/**
 * Class Support
 * @package App\Models
 * @version January 7, 2020, 6:53 am UTC
 *
 * @property integer user_id
 * @property integer group_id
 * @property double total_payout
 */
class PayoutReport extends Model
{
    public $table = 'payout_report';

    public $fillable = [
        'user_id',
        'group_id',
        'total_payout',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function titles()
    {
        return $this->belongsTo(TicketTitle::class, 'title_id');
    }

}
