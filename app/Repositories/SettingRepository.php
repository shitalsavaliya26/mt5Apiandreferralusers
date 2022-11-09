<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\BaseRepository;

/**
 * Class SettingRepository
 * @package App\Repositories
 * @version January 2, 2020, 12:00 pm UTC
*/

class SettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'admin_email',
        'withdraw_fees',
        'withdraw_from_day',
        'withdraw_to_day',
        'allow_first_withdraw',
        'minimum_withdraw_amount',
        'profit_sharing_commision_l1',
        'profit_sharing_commision_l2',
        'profit_sharing_commision_l3'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Setting::class;
    }
}
