<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function make()
    {
        return $this->belongsTo(Make::class);
    }

    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }
}
