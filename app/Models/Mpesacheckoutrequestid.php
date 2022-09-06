<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mpesacheckoutrequestid extends Model
{
    use HasFactory;

    protected $table = 'mpesacheckoutrequestids';
    protected $fillable = ['checkoutrequestid','user_id'];

    public function tenantuser ()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

}
