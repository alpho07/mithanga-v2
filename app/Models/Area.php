<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
/**
 * Class Area
 *
 * @property $id
 * @property $name
 * @property $rate
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Area extends Model
{
    
    static $rules = [
		'name' => 'required',
		'rate' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','rate'];
    
    function client(){
        return $this->hasMany(Client::class,'area');
    }
    
    



}
