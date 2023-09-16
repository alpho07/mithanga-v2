<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SettingsNbrd
 *
 * @property $id
 * @property $company_name
 * @property $company_name_short
 * @property $billing_rate_per_cubic_m
 * @property $discount_rate
 * @property $reconnection_fee
 * @property $bank_name
 * @property $branch
 * @property $account_number
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SettingsNbrd extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['company_name','company_name_short','billing_rate_per_cubic_m','discount_rate','reconnection_fee','bank_name','branch','account_number'];



}
