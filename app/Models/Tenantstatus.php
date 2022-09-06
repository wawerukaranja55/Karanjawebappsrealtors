<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenantstatus extends Model
{
    use HasFactory;

    protected $table = 'tenantstatuses';
    protected $fillable = ['tenantstatus_title','status'];

    public function tenants(){
        return $this ->belongsToMany(User::class);
    }
}
