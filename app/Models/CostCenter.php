<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CostCenter
 *
 * @property $id
 * @property $center
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class CostCenter extends Model
{
    
    static $rules = [
		'center' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['center'];



}
