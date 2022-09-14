<?php

namespace App\Repositories;

use App\Models\ThirdPartyTokens;
use App\Repositories\BaseRepository;

/**
 * Class ThirdPartyTokensRepository
 * @package App\Repositories
 * @version September 14, 2022, 8:48 am PST
*/

class ThirdPartyTokensRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'Company',
        'AccessKey',
        'Token',
        'ExpiresIn',
        'Status',
        'Notes'
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
        return ThirdPartyTokens::class;
    }
}
