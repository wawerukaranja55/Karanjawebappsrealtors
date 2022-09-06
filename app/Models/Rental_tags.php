<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental_tags extends Model
{
    use HasFactory;

    protected $fillable = ['rentaltag_title','status'];

    public function tagshouse ()
    {
        return $this->belongsToMany(Rental_house::class,'rentalhouse_tags','tag_id','rental_id');
    }
    
}
