<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Tokens
 * @package App\Models
 * @version July 8, 2021, 1:03 am UTC
 *
 * @property string $userid
 * @property string $token
 */
class Tokens extends Model
{
    // use SoftDeletes;

    use HasFactory;

    public $table = 'tokens';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $connection = "sqlsrv";

    public $fillable = [
        'userid',
        'token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'userid' => 'string',
        'token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'userid' => 'required|string|max:255',
        'token' => 'required|string|max:4000',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
