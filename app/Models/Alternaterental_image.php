<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternaterental_image extends Model
{
    use HasFactory;

    protected $fillable=['house_id','image','status'];

    public function imgrentalhouses ()
    {
        return $this->belongsTo('App\Models\Rental_house','house_id');
    }
}
