<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class UserAppLogs
 * @package App\Models
 * @version October 25, 2021, 12:50 am UTC
 *
 * @property string $Type
 * @property string $Details
 * @property string $LatLong
 */
class UserAppLogs extends Model
{
    // use SoftDeletes;

    use HasFactory;

    public $table = 'UserAppLogs';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $connection = "sqlsrv";

    public $fillable = [
        'Type',
        'Details',
        'LatLong',
        'UserId'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'Type' => 'string',
        'Details' => 'string',
        'LatLong' => 'string',
        'UserId' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'Type' => 'nullable|string|max:500',
        'Details' => 'nullable|string|max:2000',
        'LatLong' => 'nullable|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'UserId' => 'string|nullable'
    ];

    
}
