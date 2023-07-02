<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Make extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function carModel(): HasMany
    {
        return $this->hasMany(CarModel::class);
    }
}
