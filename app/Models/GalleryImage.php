<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;

    // Define the attributes that are not mass assignable
    protected $guarded = ['user_id'];

    // Define any attributes that you want to fill dynamically
    protected $fillable = ['caption', 'category', 'image'];

    // If you want to dynamically set values during model creation/update,
    // you can use mutators or handle it in your controller.

    // For example, using mutators:
    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = $value;
    }

    public function setCaptionAttribute($value)
    {
        $this->attributes['caption'] = $value;
    }

    public function setCategoryAttribute($value)
    {
        $this->attributes['category'] = $value;
    }

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = $value;
    }
}