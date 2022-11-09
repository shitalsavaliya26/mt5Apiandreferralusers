<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Support\Facades\App;

/**
 * Class Support
 * @package App\Models
 * @version January 7, 2020, 6:53 am UTC
 *
 * @property integer user_id
 * @property string title_id
 * @property integer status
 */
class Support extends Model
{
    public $table = 'support';

    public $fillable = [
        'user_id',
        'title_id',
        'status'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function titles()
    {
        return $this->belongsTo(TicketTitle::class, 'title_id');
    }

    public function supportMessage()
    {
        return $this->hasMany(TicketMessage::class, 'support_id', 'id');
    }
}
