<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Category extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;


    protected $hidden = ['created_at' , 'deleted_at' , 'image'];
    
    protected $appends = ['image_url'];

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



    //Relations
    // One to Mane => one Category Has many Products
    public function products()
    {                                       // Product         Categories      
        return $this->hasMany(Product::class, 'category_id' , 'id' );
        // return $this->hasMany(Product::class);
    }
    




    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('category-images');
    }

    public function getImageUrlAttribute()
    {
        $media = $this->getFirstMedia('category-images');
        if ($media) {
            return $media->getUrl();
        }

        if (! $this->image) {
            return asset('images/defluat.jpg');
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return asset('uploads/' . $this->image);
    }

    public function getMediaImagesAttribute()
    {
        return $this->getMedia('category-images');
    }

// public function setNameAttribute($value)
// {
//     $this->attributes['name']=Str::upper($value);
// }



}
