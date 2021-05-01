<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Patient extends Model
{
    use HasFactory,HasRoles;

    public function getGenderTitleAttribute()
    {
        return $this->gender == 'M' ? 'Male' : 'Female';
    }

    public function doctors(){
        return $this->belongsTo(Doctor::class, 'doctor_id','id');
    }

    public function cities(){
        return $this->belongsTo(City::class, 'city_id','id');
    }
}
