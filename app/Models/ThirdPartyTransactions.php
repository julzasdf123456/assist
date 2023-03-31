<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ThirdPartyTransactions
 * @package App\Models
 * @version September 15, 2022, 4:43 pm PST
 *
 * @property string $AccountNumber
 * @property string $ServicePeriodEnd
 * @property string $BillNumber
 * @property number $KwhUsed
 * @property number $Amount
 * @property number $Surcharge
 * @property number $TotalAmount
 * @property string $Company
 * @property string $Teller
 */
class ThirdPartyTransactions extends Model
{
    // use SoftDeletes;

    use HasFactory;

    public $table = 'ThirdPartyTransactions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $connection = "sqlsrv";

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $fillable = [
        'AccountNumber',
        'ServicePeriodEnd',
        'BillNumber',
        'KwhUsed',
        'Amount',
        'Surcharge',
        'TotalAmount',
        'Company',
        'Teller',
        'ORNumber',
        'Status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'AccountNumber' => 'string',
        'ServicePeriodEnd' => 'date',
        'BillNumber' => 'string',
        'KwhUsed' => 'float',
        'Amount' => 'float',
        'Surcharge' => 'float',
        'TotalAmount' => 'float',
        'Company' => 'string',
        'Teller' => 'string',
        'ORNumber' => 'string',
        'Status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'AccountNumber' => 'nullable|string|max:255',
        'ServicePeriodEnd' => 'nullable',
        'BillNumber' => 'nullable|string|max:255',
        'KwhUsed' => 'nullable|numeric',
        'Amount' => 'nullable|numeric',
        'Surcharge' => 'nullable|numeric',
        'TotalAmount' => 'nullable|numeric',
        'Company' => 'nullable|string|max:255',
        'Teller' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'ORNumber' => 'nullable|string',
        'Status' => 'nullable|string'
    ];

    
}
