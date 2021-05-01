<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class City extends Model
{
    use HasFactory,HasRoles,Notifiable;

    public function getStatusAttribute()
    {
        if ($this->active) {
            return "Active";
        } else {
            return "InActive";
        }
    }

    public function admins(){
        return $this->hasMany(Admin::class,'city_id','id');
    }

    public function secrtaries(){
        return $this->hasMany(Secrtary::class,'city_id','id');
    }

    public function patients(){
        return $this->hasMany(Patient::class,'city_id','id');
    }

    public function doctors(){
        return $this->hasMany(Doctor::class,'city_id','id');
    }
}
