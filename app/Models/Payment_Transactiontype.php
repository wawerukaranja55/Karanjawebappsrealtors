<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_Transactiontype extends Model
{
    use HasFactory;
    protected $table = 'payment__transactiontypes';
    protected $fillable = ['name','status','number'];
}
