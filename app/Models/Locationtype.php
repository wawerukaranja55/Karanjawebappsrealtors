<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locationtype extends Model
{
    use HasFactory;

    public function locations()
    {
        return $this->hasMany(Location::class,'locationtype_id');
    }
}
