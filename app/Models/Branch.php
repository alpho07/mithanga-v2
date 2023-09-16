<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Branch
 *
 * @property $id
 * @property $name
 * @property $bank_id
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Branch extends Model {

    static $rules = [
        'name' => 'required',
        'bank_id' => 'required',
    ];
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'bank_id'];

    function bank() {
       return $this->belongsTo(Bank::class);
    }

}
