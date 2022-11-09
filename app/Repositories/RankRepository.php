<?php

namespace App\Repositories;

use App\Models\Rank;
use App\Repositories\BaseRepository;

/**
 * Class RankRepository
 * @package App\Repositories
 * @version December 31, 2019, 6:57 am UTC
*/

class RankRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'own_package',
        'direct_sale',
        'downline',
        'direct_downline',
        'total_downline',
        'pipes_commison',
        'package_overriding',
        'leader_bonus',
        'profit_sharing'
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
        return Rank::class;
    }
}
