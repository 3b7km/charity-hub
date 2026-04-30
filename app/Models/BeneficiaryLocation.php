<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeneficiaryLocation extends Model
{
    protected $fillable = [
        'campaign_id',
        'location_name',
        'latitude',
        'longitude',
        'beneficiary_count',
        'notes',
    ];
}
