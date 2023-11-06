<?php

namespace App\Models;

use App\Models\User;
use App\Models\Rentalhousesize;
use App\Models\Alternaterental_image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rental_house extends Model
{
    use HasFactory;
    protected $table = 'rental_houses';
    protected $fillable = ['rental_name','landlord_id','monthly_rent','rental_image','rental_video','rental_details','rentalcat_id','rental_address','rental_status','location_id','total_rooms','tagimages_status','parking','cctv_cameras','servant_quarters','waterbill','electricitybill','balcony','vacancystatus','wifi'];

    function housecategory(){
        return $this->belongsTo('App\Models\Rental_category','rentalcat_id');
    }

    function houselocation(){
        return $this->belongsTo('App\Models\Location','location_id');
    }

    function vacancystatuses(){
        return $this->belongsTo('App\Models\Vacancy_status','vacancy_status','id');
    }

    // a landord may have many houses
    function landlordhses(){
        return $this->belongsTo('App\Models\User','id','landlord_id');
    }

    function housetags(){
        return $this->belongsToMany(Rental_tags::class,'rentalhouse_tags','rental_id','tag_id');
    }

    function rentalalternateimages(){
        return $this->hasMany(Alternaterental_image::class,'house_id'); 
    }

    public function hsesusers(){
        return $this->hasMany(User::class,'house_id','id');
    }

    public function hseroomsizes()
    {
        return $this->hasMany(Rentalhousesize::class,'rentalhse_id','id');
    }
}
