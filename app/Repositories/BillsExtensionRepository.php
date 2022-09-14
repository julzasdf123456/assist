<?php

namespace App\Repositories;

use App\Models\BillsExtension;
use App\Repositories\BaseRepository;

/**
 * Class BillsExtensionRepository
 * @package App\Repositories
 * @version September 14, 2022, 10:16 am PST
*/

class BillsExtensionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ServicePeriodEnd',
        'GenerationVAT',
        'TransmissionVAT',
        'SLVAT',
        'DistributionVAT',
        'OthersVAT',
        'Item5',
        'Item6',
        'Item7',
        'Item8',
        'Item9',
        'Item10',
        'Item11',
        'Item12',
        'Item13',
        'Item14',
        'Item15',
        'Item16',
        'Item17',
        'Item18',
        'Item19',
        'Item20',
        'Item21',
        'Item22',
        'Item23',
        'Item24',
        'rowguid'
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
        return BillsExtension::class;
    }
}
