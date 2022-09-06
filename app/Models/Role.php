<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    protected $fillable=['role_name'];

        // Relationship between user and his roles
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
