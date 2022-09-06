<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rentalhousesize extends Model
{
    use HasFactory;
    protected $table = 'rentalhousesizes';
    protected $fillable = ['rentalhse_id','roomsize_price','total_rooms','status'];
}
