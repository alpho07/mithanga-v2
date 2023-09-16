<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 *
 * @property $id
 * @property $client_id
 * @property $description
 * @property $date
 * @property $type
 * @property $amount
 * @property $units
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Transaction extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
       protected $fillable = ['client_id','description','date','type','amount','units','mop','bank','branch','reference','staff','amount_received'];



}
