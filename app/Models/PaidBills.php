<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PaidBills
 * @package App\Models
 * @version July 8, 2021, 3:39 am UTC
 *
 * @property string $rowguid
 * @property string $BillNumber
 * @property string|\Carbon\Carbon $ServicePeriodEnd
 * @property integer $Power
 * @property integer $Meter
 * @property integer $PR
 * @property integer $ServiceFee
 * @property integer $Others1
 * @property integer $Others2
 * @property string|\Carbon\Carbon $ORDate
 * @property integer $MDRefund
 * @property string $Form2306
 * @property string $Form2307
 * @property integer $Amount2306
 * @property integer $Amount2307
 * @property string|\Carbon\Carbon $PostingDate
 * @property integer $PostingSequence
 * @property integer $PromptPayment
 * @property integer $Surcharge
 * @property integer $SLAdjustment
 * @property integer $OtherDeduction
 * @property integer $Others
 * @property integer $NetAmount
 * @property string $PaymentType
 * @property string $ORNumber
 * @property string $Teller
 * @property string $DCRNumber
 */
class PaidBills extends Model
{
    // use SoftDeletes;

    use HasFactory;

    public $table = 'PaidBills';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $connection = "sqlsrv2";

    public $fillable = [
        'rowguid',
        'BillNumber',
        'ServicePeriodEnd',
        'Power',
        'Meter',
        'PR',
        'ServiceFee',
        'Others1',
        'Others2',
        'ORDate',
        'MDRefund',
        'Form2306',
        'Form2307',
        'Amount2306',
        'Amount2307',
        'PostingDate',
        'PostingSequence',
        'PromptPayment',
        'Surcharge',
        'SLAdjustment',
        'OtherDeduction',
        'Others',
        'NetAmount',
        'PaymentType',
        'ORNumber',
        'Teller',
        'DCRNumber'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'rowguid' => 'string',
        'AccountNumber' => 'string',
        'BillNumber' => 'string',
        'ServicePeriodEnd' => 'datetime',
        'Power' => 'integer',
        'Meter' => 'integer',
        'PR' => 'integer',
        'ServiceFee' => 'integer',
        'Others1' => 'integer',
        'Others2' => 'integer',
        'ORDate' => 'datetime',
        'MDRefund' => 'integer',
        'Form2306' => 'string',
        'Form2307' => 'string',
        'Amount2306' => 'integer',
        'Amount2307' => 'integer',
        'PostingDate' => 'datetime',
        'PostingSequence' => 'integer',
        'PromptPayment' => 'integer',
        'Surcharge' => 'integer',
        'SLAdjustment' => 'integer',
        'OtherDeduction' => 'integer',
        'Others' => 'integer',
        'NetAmount' => 'integer',
        'PaymentType' => 'string',
        'ORNumber' => 'string',
        'Teller' => 'string',
        'DCRNumber' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'rowguid' => 'required|string',
        'BillNumber' => 'nullable|string|max:10',
        'ServicePeriodEnd' => 'required',
        'Power' => 'nullable|integer',
        'Meter' => 'nullable|integer',
        'PR' => 'nullable|integer',
        'ServiceFee' => 'nullable|integer',
        'Others1' => 'nullable|integer',
        'Others2' => 'nullable|integer',
        'ORDate' => 'nullable',
        'MDRefund' => 'nullable|integer',
        'Form2306' => 'nullable|string|max:50',
        'Form2307' => 'nullable|string|max:50',
        'Amount2306' => 'nullable|integer',
        'Amount2307' => 'nullable|integer',
        'PostingDate' => 'nullable',
        'PostingSequence' => 'nullable|integer',
        'PromptPayment' => 'nullable|integer',
        'Surcharge' => 'nullable|integer',
        'SLAdjustment' => 'nullable|integer',
        'OtherDeduction' => 'nullable|integer',
        'Others' => 'nullable|integer',
        'NetAmount' => 'nullable|integer',
        'PaymentType' => 'nullable|string|max:20',
        'ORNumber' => 'nullable|string|max:20',
        'Teller' => 'nullable|string|max:50',
        'DCRNumber' => 'nullable|string|max:20'
    ];

    
}
