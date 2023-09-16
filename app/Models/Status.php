<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

/**
 * Class Status
 *
 * @property $id
 * @property $status
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Status extends Model {

    static $rules = [
        'status' => 'required',
    ];
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['status'];

    function client() {
        return $this->belongsTo(Client::class, 'status');
    }

}
