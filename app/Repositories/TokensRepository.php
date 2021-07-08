<?php

namespace App\Repositories;

use App\Models\Tokens;
use App\Repositories\BaseRepository;

/**
 * Class TokensRepository
 * @package App\Repositories
 * @version July 8, 2021, 1:03 am UTC
*/

class TokensRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'userid',
        'token'
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
        return Tokens::class;
    }
}
