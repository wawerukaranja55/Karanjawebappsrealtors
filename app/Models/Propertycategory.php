<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propertycategory extends Model
{
    use HasFactory;
    protected $table = 'propertycategories';
    protected $fillable = ['propertycat_title','status'];

    public static function propertycategorydetails($url)
    {
        $propertycategorydetails=Propertycategory::where('propertycat_title',$url)->select('id','propertycat_title')->first();

        $propertyids=array();
        $propertyids[]=$propertycategorydetails['id'];

        return array('propertyids'=>$propertyids,'propertycategorydetails'=>$propertycategorydetails);
    }

    public function onsaleproperties()
    {
        return $this->hasMany(Property::class,'propertycat_id');
    }
}
