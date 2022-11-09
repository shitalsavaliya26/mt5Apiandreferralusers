<?php

namespace App\Repositories;

use App\Models\Trader;
use App\Repositories\BaseRepository;

/**
 * Class TraderRepository
 * @package App\Repositories
 * @version December 31, 2019, 10:30 am UTC
*/

class TraderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'subtitle',
        'profile_picture',
        'graph_picture',
        'description',
        'minimum_amount',
        'maximum_amount',
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
        return Trader::class;
    }
}
