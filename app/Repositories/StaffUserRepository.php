<?php

namespace App\Repositories;

use App\Admin;
use App\Models\Role;
use App\Models\StaffUser;
use App\Repositories\BaseRepository;

/**
 * Class StaffUserRepository
 * @package App\Repositories
 * @version January 30, 2020, 9:42 am UTC
*/

class StaffUserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
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
        return Admin::class;
    }
}
