<?php

namespace App\Repositories;

use App\Models\AccountLinks;
use App\Repositories\BaseRepository;

/**
 * Class AccountLinksRepository
 * @package App\Repositories
 * @version July 7, 2021, 6:01 am UTC
*/

class AccountLinksRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'UserId',
        'AccountNumber'
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
        return AccountLinks::class;
    }
}
