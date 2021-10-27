<?php

namespace App\Repositories;

use App\Models\Notifiers;
use App\Repositories\BaseRepository;

/**
 * Class NotifiersRepository
 * @package App\Repositories
 * @version October 26, 2021, 8:25 am PST
*/

class NotifiersRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'Type',
        'Title',
        'Details',
        'Town',
        'Barangay',
        'DateTimeFrom',
        'DateTimeTo',
        'CommentsEnabled'
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
        return Notifiers::class;
    }
}
