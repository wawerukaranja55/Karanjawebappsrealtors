<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Room_name;
use App\Models\Rental_house;
use App\Models\Tenantstatus;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name','email','role_id','phone','admin_status','avatar','password',
        'house_name','is_landlord'
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationship between user and his roles

    public function roles(){
        return $this->belongsToMany('App\Models\Role','role_user','user_id','role_id');
    }

    // Relationship between user and a rental house

    public function rentalhses(){
        return $this->belongsTo('App\Models\Rental_house','house_id');
    }


        // a user has checkout ids
    function mpesapayments(){
        return $this->hasMany('App\Models\Mpesapayment'); 
        // return $this->belongsToMany('App\Models\Mpesacheckoutrequestid','mpesarqstid_users','usercheckoutrqst_id','mpesacheckoutrqst_id');
    }

        // a user may have many rooms
    public function hserooms(){
        return $this->belongsToMany('App\Models\Room_name','house_userrooms','userhse_id','rentalroom_id');
    }

    public function tenantstatus(){
        return $this->belongsToMany('App\Models\Tenantstatus','tenantstatus_user','user_id','tenantstatus_id');
    }

    public function hasAnyRoles($roles)
    {
        if($this->roles()->whereIn('role_name',$roles)->first())
        {
            return true;
        }

        return false;
    }

    // a landlord may have many houses
    public function landlordhouses()
    {
        return $this->hasMany(Rental_house::class,'landlord_id');
    }
}
