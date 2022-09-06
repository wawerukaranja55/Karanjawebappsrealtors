<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mpesapayment extends Model
{
    use HasFactory;

    protected $table = 'mpesapayments';
    protected $fillable = ['phone','mpesatransaction_id','amount','user_id','tenant_name'];

    function userdetails(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

}
