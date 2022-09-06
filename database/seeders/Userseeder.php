<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $theceorole=Role::where(['role_name'=>'The Ceo'])->first();
        $managingdirectorrole=Role::where(['role_name'=>'General Manager'])->first();
        $admin1role=Role::where(['role_name'=>'Admin 1'])->first();
        $admin2role=Role::where(['role_name'=>'Admin 2'])->first();
        $admin3role=Role::where(['role_name'=>'Admin 3'])->first();
        $developerrole=Role::where(['role_name'=>'Developer'])->first();

        $developer=User::create([
            'name'=>'developerKen abraham',
            'phone'=>'0712345678',
            'id_number'=>'22712345678',
            'is_admin'=>1,
            'is_approved'=>'1',
            'role_id'=>'0',
            'house_id'=>'1',
            'email'=>'admin1kenabraham@gmail.com',
            'email_verified_at'=>now(),
            'password'=>Hash::make('password'),
            'remember_token'=>Str::random(10)
        ]);

        $admin3=User::create([
            'name'=>'admin3jane adams',
            'phone'=>'0712345678',
            'id_number'=>'22712345678',
            'is_admin'=>1,
            'is_approved'=>'1',
            'role_id'=>'0',
            'house_id'=>'1',
            'email'=>'admin3janeadams@gmail.com',
            'email_verified_at'=>now(),
            'password'=>Hash::make('password'),
            'remember_token'=>Str::random(10)
        ]);

        $admin2=User::create([
            'name'=>'admin2mary jacobs',
            'phone'=>'0712345678',
            'id_number'=>'22712345678',
            'is_admin'=>1,
            'is_approved'=>'1',
            'role_id'=>'0',
            'house_id'=>'1',
            'email'=>'admin2maryjacobs@gmail.com',
            'email_verified_at'=>now(),
            'password'=>Hash::make('password'),
            'remember_token'=>Str::random(10)
        ]);

        $admin1=User::create([
            'name'=>'admin1Ken lincoln',
            'phone'=>'0712345678',
            'id_number'=>'22712345678',
            'is_admin'=>1,
            'is_approved'=>'1',
            'role_id'=>'0',
            'house_id'=>'1',
            'email'=>'admin1kenlincoln@gmail.com',
            'email_verified_at'=>now(),
            'password'=>Hash::make('password'),
            'remember_token'=>Str::random(10)
        ]);

        $theceo=User::create([
            'name'=>'theceodavid jayden',
            'phone'=>'0712345678',
            'id_number'=>'22712345678',
            'is_admin'=>1,
            'is_approved'=>'1',
            'role_id'=>'0',
            'house_id'=>'1',
            'email'=>'theceodavidjayden@gmail.com',
            'email_verified_at'=>now(),
            'password'=>Hash::make('password'),
            'remember_token'=>Str::random(10)
        ]);

        $managingdirector=User::create([
            'name'=>'mdjames kelvin',
            'phone'=>'0712345678',
            'id_number'=>'22712345678',
            'is_admin'=>1,
            'is_approved'=>'1',
            'role_id'=>'0',
            'house_id'=>'1',
            'email'=>'mdjameskelvin@gmail.com',
            'email_verified_at'=>now(),
            'password'=>Hash::make('password'),
            'remember_token'=>Str::random(10)
        ]);

        $theceo->roles()->attach($theceorole);
        $managingdirector->roles()->attach($managingdirectorrole);
        $developer->roles()->attach($developerrole);
        $admin3->roles()->attach($admin3role);
        $admin2->roles()->attach($admin2role);
        $admin1->roles()->attach($admin1role);

        $managingdirector->hserooms()->attach(1);
        $admin1->hserooms()->attach(2);
        $admin2->hserooms()->attach(3);
        $admin3->hserooms()->attach(4);
        $developer->hserooms()->attach(5);
        $theceo->hserooms()->attach(6);

        $managingdirector->tenantstatus()->attach(1);
        $admin1->tenantstatus()->attach(1);
        $admin2->tenantstatus()->attach(1);
        $admin3->tenantstatus()->attach(1);
        $developer->tenantstatus()->attach(1);
        $theceo->tenantstatus()->attach(1);
    }
}
