<?php

namespace App\Repositories;

use App\Models\CMS;
use App\Repositories\BaseRepository;

/**
 * Class CMSRepository
 * @package App\Repositories
 * @version December 31, 2019, 10:30 am UTC
*/

class CMSRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'details',
        'image',
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
        return CMS::class;
    }
}
