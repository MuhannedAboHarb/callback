<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable=
    [
     'name' ,'slug','parent_id','description','image'
    ];


    public static function booted()
    {
        static::forceDeleted(function($category){
            if($category->image)
            {
                Storage::disk('uploads')->delete($category->image);
            }
        });

        static::saving(function($category){
            $category->slug=Str::slug($category->name);
        });
    }

}
