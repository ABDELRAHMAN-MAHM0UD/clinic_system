<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment; // <--- مهم جداً

class Doctor extends Model
{
    public function appointments()
{
    return $this->hasMany(Appointment::class);
}

}
