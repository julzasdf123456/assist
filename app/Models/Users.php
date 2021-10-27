<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Users
 * @package App\Models
 * @version July 7, 2021, 4:53 am UTC
 *
 */
class Users extends Model
{
    // use SoftDeletes;

    use HasFactory;

    public $table = 'users';

    protected $dates = ['deleted_at'];

    public $connection = "sqlsrv";

    public $fillable = [
        'activity',
        'remember_token',
        'contactno'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'contactno' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'activity' => 'string|nullable',
        'remember_token' => 'string|nullable',
        'contactno' => 'string|nullable',
    ];

    
}
