<?php

namespace App\Repositories;

use App\Models\UserAppLogs;
use App\Repositories\BaseRepository;

/**
 * Class UserAppLogsRepository
 * @package App\Repositories
 * @version October 25, 2021, 12:50 am UTC
*/

class UserAppLogsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'Type',
        'Details',
        'LatLong'
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
        return UserAppLogs::class;
    }
}
