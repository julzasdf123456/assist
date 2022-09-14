<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BillsExtension
 * @package App\Models
 * @version September 14, 2022, 10:16 am PST
 *
 * @property string|\Carbon\Carbon $ServicePeriodEnd
 * @property integer $GenerationVAT
 * @property integer $TransmissionVAT
 * @property integer $SLVAT
 * @property integer $DistributionVAT
 * @property integer $OthersVAT
 * @property integer $Item5
 * @property integer $Item6
 * @property integer $Item7
 * @property string $Item8
 * @property integer $Item9
 * @property integer $Item10
 * @property integer $Item11
 * @property integer $Item12
 * @property integer $Item13
 * @property integer $Item14
 * @property integer $Item15
 * @property integer $Item16
 * @property integer $Item17
 * @property integer $Item18
 * @property integer $Item19
 * @property integer $Item20
 * @property integer $Item21
 * @property integer $Item22
 * @property integer $Item23
 * @property integer $Item24
 * @property string $rowguid
 */
class BillsExtension extends Model
{
    // use SoftDeletes;

    use HasFactory;

    public $table = 'BillsExtension';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $connection = "sqlsrv2";

    public $fillable = [
        // 'ServicePeriodEnd',
        // 'GenerationVAT',
        // 'TransmissionVAT',
        // 'SLVAT',
        // 'DistributionVAT',
        // 'OthersVAT',
        // 'Item5',
        // 'Item6',
        // 'Item7',
        // 'Item8',
        // 'Item9',
        // 'Item10',
        // 'Item11',
        // 'Item12',
        // 'Item13',
        // 'Item14',
        // 'Item15',
        // 'Item16',
        // 'Item17',
        // 'Item18',
        // 'Item19',
        // 'Item20',
        // 'Item21',
        // 'Item22',
        // 'Item23',
        // 'Item24',
        // 'rowguid'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'AccountNumber' => 'string',
        'ServicePeriodEnd' => 'datetime',
        'GenerationVAT' => 'integer',
        'TransmissionVAT' => 'integer',
        'SLVAT' => 'integer',
        'DistributionVAT' => 'integer',
        'OthersVAT' => 'integer',
        'Item5' => 'integer',
        'Item6' => 'integer',
        'Item7' => 'integer',
        'Item8' => 'string',
        'Item9' => 'integer',
        'Item10' => 'integer',
        'Item11' => 'integer',
        'Item12' => 'integer',
        'Item13' => 'integer',
        'Item14' => 'integer',
        'Item15' => 'integer',
        'Item16' => 'integer',
        'Item17' => 'integer',
        'Item18' => 'integer',
        'Item19' => 'integer',
        'Item20' => 'integer',
        'Item21' => 'integer',
        'Item22' => 'integer',
        'Item23' => 'integer',
        'Item24' => 'integer',
        'rowguid' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'ServicePeriodEnd' => 'required',
        'GenerationVAT' => 'nullable|integer',
        'TransmissionVAT' => 'nullable|integer',
        'SLVAT' => 'nullable|integer',
        'DistributionVAT' => 'nullable|integer',
        'OthersVAT' => 'nullable|integer',
        'Item5' => 'nullable|integer',
        'Item6' => 'nullable|integer',
        'Item7' => 'nullable|integer',
        'Item8' => 'nullable|string|max:10',
        'Item9' => 'nullable|integer',
        'Item10' => 'nullable|integer',
        'Item11' => 'nullable|integer',
        'Item12' => 'nullable|integer',
        'Item13' => 'nullable|integer',
        'Item14' => 'nullable|integer',
        'Item15' => 'nullable|integer',
        'Item16' => 'nullable|integer',
        'Item17' => 'nullable|integer',
        'Item18' => 'nullable|integer',
        'Item19' => 'nullable|integer',
        'Item20' => 'nullable|integer',
        'Item21' => 'nullable|integer',
        'Item22' => 'nullable|integer',
        'Item23' => 'nullable|integer',
        'Item24' => 'nullable|integer',
        'rowguid' => 'required|string'
    ];

    
}
