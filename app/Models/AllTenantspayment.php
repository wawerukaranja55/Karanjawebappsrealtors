<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllTenantspayment extends Model
{
    use HasFactory;

    protected $table="all_tenantspayments";

    protected $fillable = ['user_id','transactiontype_id','receipt_number','rental_name','total_rent','amount_paid','total_arrears','overpaid_amount'];

    function userpaymentdetails(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    function paymenttransactiontype(){
        return $this->belongsTo('App\Models\Payment_Transactiontype','transactiontype_id','id');
    }

    // a payment may belong to many rooms
    public function usersrooms(){
        return $this->belongsToMany('App\Models\Room_name','house_userrooms','userhse_id','rentalroom_id');
    }

    // all amounts paid by a tenant
    public static function totalamounts($year, $month)
    {
        return AllTenantspayment::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('amount_paid');
    }
}
