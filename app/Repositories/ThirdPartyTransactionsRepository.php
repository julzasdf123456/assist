<?php

namespace App\Repositories;

use App\Models\ThirdPartyTransactions;
use App\Repositories\BaseRepository;

/**
 * Class ThirdPartyTransactionsRepository
 * @package App\Repositories
 * @version September 15, 2022, 4:43 pm PST
*/

class ThirdPartyTransactionsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'AccountNumber',
        'ServicePeriodEnd',
        'BillNumber',
        'KwhUsed',
        'Amount',
        'Surcharge',
        'TotalAmount',
        'Company',
        'Teller'
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
        return ThirdPartyTransactions::class;
    }
}
