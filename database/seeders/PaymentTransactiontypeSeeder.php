<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment_Transactiontype;

class PaymentTransactiontypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactiontype=[
            ['id'=>1,'number'=>'12345','name'=>'Mpesa Paybill','status'=>'1'],
            ['id'=>2,'number'=>'345678','name'=>'Equity','status'=>'1']
        ];

        Payment_Transactiontype::insert($transactiontype);
    }
}
