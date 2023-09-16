<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LegalCenter
 *
 * @property $id
 * @property $center
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LegalCenter extends Model
{
    
    static $rules = [
		'center' => 'required',
		'amount' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['center','amount'];



}
