<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusLog extends Model
{
    protected $fillable = [
        'shipment_id',
        'status',
        'location'
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
