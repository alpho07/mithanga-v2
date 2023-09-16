<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

/**
 * Class Client
 *
 * @property $id
 * @property $area
 * @property $account_name
 * @property $phone_no
 * @property $account_open_date
 * @property $meter_number
 * @property $plot_number
 * @property $status
 * @property $connection_date
 * @property $vaccation_date
 * @property $meter_reading_date
 * @property $avatar
 * @property $national_id
 *
 * @property Area $area
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Client extends Model {

    static $rules = [
        'area' => 'required',
        'account_name' => 'required',
        'phone_no' => 'required',
        //'status' => 'required',
    ];
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id','area', 'account_name', 'phone_no', 'account_open_date', 'meter_number', 'plot_number', 'status', 'connection_date', 'vaccation_date', 'meter_reading_date', 'avatar', 'national_id', 'kra_pin','borehole_tenant'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function area() {
        return $this->belongsTo(Area::class);
    }

    public function status() {
        return $this->hasOne('App\Models\Status', 'id', 'status');
    }

}
