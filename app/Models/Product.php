<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes ;

    protected $fillable = [
        'name' , 'slug' , 'description' , 'category_id' , 'price' , 'compare_price' , 'cost',
        'quantity', 'availabillty' , 'status' , 'image' , 'sku' , 'barcode'
    ];

    public static function statusOptions()
    {
     return [
        'active' => 'Active',
        'draft'=>'Draft',
        'archived'=> 'Archived'
     ];
    }


    public static function availabillties()
    {
        return [
            'in-stock'=>'In Stock',
            'out-of-stock'=> 'Out Of Stock',
            'back-order'=> 'Back Order'
        ];
    }




}
