<?php

namespace App\Repositories;
use App\Repositories\BaseRepository;
use App\User;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version December 27, 2019, 5:26 am UTC
*/

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email'
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
        return User::class;
    }
}
