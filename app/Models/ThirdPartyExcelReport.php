<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ThirdPartyExcelReport
 * @package App\Models
 * @version October 2, 2024, 4:32 pm PST
 *
 * @property string $AccountNumber
 * @property string $BillingPeriod
 * @property number $AmountDue
 * @property number $Surcharge
 */
class ThirdPartyExcelReport extends Model
{
    // use SoftDeletes;

    use HasFactory;

    public $table = 'ThirdPartyExcelReport';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    // protected $dates = ['deleted_at'];



    public $fillable = [
        'id',
        'AccountNumber',
        'BillingPeriod',
        'AmountDue',
        'Surcharge'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'AccountNumber' => 'string',
        'BillingPeriod' => 'date',
        'AmountDue' => 'decimal:2',
        'Surcharge' => 'decimal:2'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'AccountNumber' => 'nullable|string|max:50',
        'BillingPeriod' => 'nullable',
        'AmountDue' => 'nullable|numeric',
        'Surcharge' => 'nullable|numeric',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
