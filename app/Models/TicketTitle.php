<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class TicketTitle
 * @package App\Models
 * @version January 7, 2020, 6:53 am UTC
 *
 * @property integer id
 * @property string title
 */
class TicketTitle extends Model
{
    public $table = 'ticket_titles';

    public $fillable = [
        'id',
        'title',
    ];
}
