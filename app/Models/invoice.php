<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    
    protected $fillable = ['appointment_id', 'amount', 'status'];

public function appointment()
{
    return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
}

    
}
