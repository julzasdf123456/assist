<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AccountMaster
 * @package App\Models
 * @version July 7, 2021, 5:28 am UTC
 *
 * @property string $rowguid
 * @property string $ComputeMode
 * @property string $RecordStatus
 * @property string|\Carbon\Carbon $ChangeDate
 * @property string $Area
 * @property string $Route
 * @property integer $SequenceNumber
 * @property string $TemporaryStatus
 * @property string $Email
 * @property string $ContactNumber
 * @property string $MReader
 * @property string $AccountID
 * @property string $Item1
 * @property string $DepositORNumber
 * @property string $TINNo
 * @property string $cust_id
 * @property string|\Carbon\Carbon $DateEntry
 * @property string $Municipal
 * @property string $Barangay
 * @property string $SApprovedBy
 * @property string $SDiscountStatus
 * @property string $SRemarks
 * @property string $BAPAECACode
 * @property integer $BillDeposit
 * @property string|\Carbon\Carbon $DepositDate
 * @property integer $TSFRental
 * @property string $Save5
 * @property string|\Carbon\Carbon $SApplicationDate
 * @property string|\Carbon\Carbon $SDiscountExpiry
 * @property string|\Carbon\Carbon $SDateOfBirth
 * @property string $SDocument
 * @property string $SOATag
 * @property string $OldRoute
 * @property string $UserName
 * @property string|\Carbon\Carbon $DeletedDate
 * @property string $GroupTag
 * @property string $SchoolTag
 * @property number $SDWLength
 * @property string $Feeder
 * @property number $CoreLoss
 * @property number $CoreLossKWHUpperLimit
 * @property string|\Carbon\Carbon $ReadDate
 * @property string|\Carbon\Carbon $UnreadDate
 * @property string $PrivilegeType
 * @property string $InstalledBy
 * @property string $InstallationType
 * @property string $RateGroup
 * @property string|\Carbon\Carbon $DisconnectionDate
 * @property string $Remarks
 * @property string $MeterNumber
 * @property string $MemberType
 * @property string $Transformer
 * @property string $Pole
 * @property string|\Carbon\Carbon $ConnectionDate
 * @property string $TurnOnNumber
 * @property string $CIFKey
 * @property string $ConsumerName
 * @property string $ConsumerAddress
 * @property string $ConsumerType
 * @property string $AccountStatus
 * @property string $BillingStatus
 */
class AccountMaster extends Model
{
    // use SoftDeletes;
    protected $primaryKey = 'AccountNumber';

    use HasFactory;

    public $table = 'AccountMaster';
    
    // const CREATED_AT = 'created_at';
    // const UPDATED_AT = 'updated_at';


    // protected $dates = ['deleted_at'];

    public $connection = "sqlsrv2";

    public $fillable = [
        'AccountNumber',
        'Area',
        'Route',
        'SequenceNumber',
        'ContactNumber',
        'Municipal',
        'Barangay',
        'MeterNumber',
        'ConnectionDate',
        'ConsumerName',
        'ConsumerAddress',
        'ConsumerType',
        'AccountStatus',
        'Email',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'AccountNumber' => 'string',
        'Area' => 'string',
        'Route' => 'string',
        'SequenceNumber' => 'integer',
        'ContactNumber' => 'string',
        'Municipal' => 'string',
        'Barangay' => 'string',
        'MeterNumber' => 'string',
        'MemberType' => 'string',
        'ConnectionDate' => 'datetime',
        'ConsumerName' => 'string',
        'ConsumerAddress' => 'string',
        'ConsumerType' => 'string',
        'AccountStatus' => 'string',
        'Email' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'Area' => 'nullable|string|max:10',
        'Route' => 'nullable|string|max:10',
        'SequenceNumber' => 'nullable|integer',
        'ContactNumber' => 'nullable|string|max:50',
        'Municipal' => 'nullable|string|max:50',
        'Barangay' => 'nullable|string|max:50',
        'MeterNumber' => 'nullable|string|max:20',
        'MemberType' => 'nullable|string|max:20',
        'ConsumerName' => 'nullable|string|max:128',
        'ConsumerAddress' => 'nullable|string|max:128',
        'ConsumerType' => 'nullable|string|max:15',
        'AccountStatus' => 'nullable|string|max:20',
        'Email' => 'nullable|string',
    ];

    
}
