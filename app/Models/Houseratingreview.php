<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Houseratingreview extends Model
{
    use HasFactory;

    function userrating(){
        return $this->belongsTo('App\Models\User','user_id');
    }

    function rentalhouse(){
        return $this->belongsTo('App\Models\Rental_house','hse_id');
    }
}
