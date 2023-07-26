<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Product extends Model
{
    use HasFactory;
    use SoftDeletes ;

    protected $fillable = [
        'name' , 'slug' , 'description' , 'category_id' , 'price' , 'compare_price' , 'cost',
        'quantity', 'availabillty' , 'status' , 'image' , 'sku' , 'barcode'
    ];


    public static function booted()
    {
        static::forceDeleted(function($product){
            if($product->image)
            {
                Storage::disk('uploads')->delete($product->image);
            }
        });

        static::saving(function($product){
            $product->slug=Str::slug($product->name);
        });
    }


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
