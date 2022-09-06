<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company_memo extends Model
{
    use HasFactory;

    // a memo has many user
    public function usersmemo(){
        return $this->belongsToMany('App\Models\User','memo_users','memo_id','usermemo_id');
    }
}
