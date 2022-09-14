<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ThirdPartyTokens
 * @package App\Models
 * @version September 14, 2022, 8:48 am PST
 *
 * @property string $Company
 * @property string $AccessKey
 * @property string $Token
 * @property string $ExpiresIn
 * @property string $Status
 * @property string $Notes
 */
class ThirdPartyTokens extends Model
{
    // use SoftDeletes;

    use HasFactory;

    public $table = 'ThirdPartyTokens';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $fillable = [
        'id',
        'Company',
        'AccessKey',
        'Token',
        'ExpiresIn',
        'Status',
        'Notes'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'Company' => 'string',
        'AccessKey' => 'string',
        'Token' => 'string',
        'ExpiresIn' => 'date',
        'Status' => 'string',
        'Notes' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'Company' => 'nullable|string|max:300',
        'AccessKey' => 'nullable|string|max:300',
        'Token' => 'nullable|string|max:600',
        'ExpiresIn' => 'nullable',
        'Status' => 'nullable|string|max:200',
        'Notes' => 'nullable|string|max:600',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
