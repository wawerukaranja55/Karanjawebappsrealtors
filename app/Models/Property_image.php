<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property_image extends Model
{
    use HasFactory;

    protected $table = 'property_images';
    protected $fillable=['property_id','image','status'];

    public function propertyimages ()
    {
        return $this->belongsTo('App\Models\Property','property_id');
    }
}
