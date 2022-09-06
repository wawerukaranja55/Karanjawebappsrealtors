<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental_category extends Model
{
    use HasFactory;

    protected $table = 'rental_categories';
    protected $fillable = ['rentalcat_title','status','rentalcat_url'];

    public static function rentalcategorydetails($url)
    {
        $rentalcategorydetails=Rental_category::where('rentalcat_url',$url)->select('id','rentalcat_title','rentalcat_url')->first();

        $catids=array();
        $catids[]=$rentalcategorydetails['id'];

        return array('catids'=>$catids,'rentalcategorydetails'=>$rentalcategorydetails);
    }

    public function rentalhses()
    {
        return $this->hasMany(Rental_house::class,'rentalcat_id');
    }
}
