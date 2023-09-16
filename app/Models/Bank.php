<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;
/**
 * Class Bank
 *
 * @property $id
 * @property $name
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Bank extends Model
{
    
    static $rules = [
		'name' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    
    function branch(){
       return  $this->hasMany(Branch::class,'bank_id');
    }



}
