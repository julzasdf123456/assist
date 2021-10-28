<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AccountLinks
 * @package App\Models
 * @version July 7, 2021, 6:01 am UTC
 *
 * @property string $UserId
 * @property string $AccountNumber
 */
class AccountLinks extends Model
{
    // use SoftDeletes;

    use HasFactory;

    public $table = 'AccountLinks';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $connection = "sqlsrv";

    public $fillable = [
        'UserId',
        'AccountNumber',
        'ConsumerName',
        'Status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'UserId' => 'string',
        'AccountNumber' => 'string',
        'ConsumerName' => 'string',
        'Status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'UserId' => 'required|string|max:255',
        'AccountNumber' => 'required|string|max:255',
        'ConsumerName' => 'required|string|max:500',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'Status' => 'nullable|string'
    ];

    
}
