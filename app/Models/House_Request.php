<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House_Request extends Model
{
    use HasFactory;

    protected $table="house_requests";

    protected $fillable = ['name','email','phone','hse_id','msg_request'];
}
