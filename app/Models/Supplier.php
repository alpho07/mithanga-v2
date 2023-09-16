<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Supplier
 *
 * @property $id
 * @property $name
 * @property $contactPerson
 * @property $phone
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Supplier extends Model
{
    
    static $rules = [
		'name' => 'required',
		'contactPerson' => 'required',
		'phone' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','contactPerson','phone'];



}
