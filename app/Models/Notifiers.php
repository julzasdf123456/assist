<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Notifiers
 * @package App\Models
 * @version October 26, 2021, 8:25 am PST
 *
 * @property string $Type
 * @property string $Title
 * @property string $Details
 * @property string $Town
 * @property string $Barangay
 * @property string|\Carbon\Carbon $DateTimeFrom
 * @property string|\Carbon\Carbon $DateTimeTo
 * @property string $CommentsEnabled
 */
class Notifiers extends Model
{
    // use SoftDeletes;

    use HasFactory;

    public $table = 'Notifiers';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $connection = "sqlsrv";

    public $fillable = [
        'Type',
        'Title',
        'Details',
        'Town',
        'Barangay',
        'DateTimeFrom',
        'DateTimeTo',
        'CommentsEnabled',
        'ToUser'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'Type' => 'string',
        'Title' => 'string',
        'Details' => 'string',
        'Town' => 'string',
        'Barangay' => 'string',
        'DateTimeFrom' => 'datetime',
        'DateTimeTo' => 'datetime',
        'ToUser' => 'string',
        'CommentsEnabled' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'Type' => 'nullable|string|max:100',
        'Title' => 'nullable|string|max:500',
        'Details' => 'nullable|string|max:3000',
        'Town' => 'nullable|string|max:10',
        'Barangay' => 'nullable|string|max:10',
        'DateTimeFrom' => 'nullable',
        'DateTimeTo' => 'nullable',
        'CommentsEnabled' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'ToUser' => 'nullable|string'
    ];

    
}
