<?php

namespace App\Repositories;

use App\Models\ThirdPartyExcelReport;
use App\Repositories\BaseRepository;

/**
 * Class ThirdPartyExcelReportRepository
 * @package App\Repositories
 * @version October 2, 2024, 4:32 pm PST
*/

class ThirdPartyExcelReportRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'AccountNumber',
        'BillingPeriod',
        'AmountDue',
        'Surcharge'
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
        return ThirdPartyExcelReport::class;
    }
}
