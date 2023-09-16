<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 *
 * @property $id
 * @property $client_id
 * @property $description
 * @property $date
 * @property $type
 * @property $amount
 * @property $units
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Payment extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['client_id','description','date','type','amount','units','more_details','bank','branch','reference','amount_received'];



}
