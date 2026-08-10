<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    //
    protected $fillable=[
        'name',
        'license_number',
        'address',
        'owner_name',
        'owner_email',
        'owner_phone',
        'status',
        'billing_cycle',
        'billing_date',
        'next_billing_date',
        'billing_status'
    ];
     protected $casts=[
        'billing_date'=>'date',
        'next_billing_date'=>'date',
            ];
}
