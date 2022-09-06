<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room_name extends Model
{
    use HasFactory;

    protected $table="room_names";

    protected $fillable = ['room_name','status','rentalhouse_id'];
}
