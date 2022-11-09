<?php

namespace App\Repositories;

use App\Models\TopupFund;
use App\Repositories\BaseRepository;

/**
 * Class TopupFundRepository
 * @package App\Repositories
 * @version January 7, 2020, 6:53 am UTC
*/

class TopupFundRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'amount',
        'reciept',
        'status'
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
        return TopupFund::class;
    }
}
