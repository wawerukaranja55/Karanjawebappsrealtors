<?php

namespace App\Models;

use App\Models\Rentalhousesize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room_name extends Model
{
    use HasFactory;

    protected $table="room_names";

    protected $fillable = ['room_name','status','rentalhouse_id','roomsize_price','is_roomsize'];

    function roomhsesizes(){
        return $this->belongsTo('App\Models\Rentalhousesize','is_roomsize','id');
    }

    function housetheroombelongsto(){
        return $this->belongsTo('App\Models\Rental_house','rentalhouse_id');
    }
}
