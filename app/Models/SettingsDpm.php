<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SettingsDpm
 *
 * @property $id
 * @property $billing_period
 * @property $due_days
 * @property $first_billing_message
 * @property $second_billing_message
 * @property $third_billing_message
 * @property $receipt_message
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SettingsDpm extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['billing_period','due_days','first_billing_message','second_billing_message','third_billing_message','receipt_message'];



}
