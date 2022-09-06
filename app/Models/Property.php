<?php

namespace App\Models;

use App\Models\Property_image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    public function propertycategory(){
        return $this->belongsTo('App\Models\Propertycategory','propertycat_id','id');
    }

    function propertylocation(){
        return $this->belongsTo('App\Models\Location','propertylocation_id','id');
    }

    function propertyimages(){
        return $this->hasMany(Property_image::class,'property_id'); 
    }
}
