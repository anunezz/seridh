<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CarouselImages extends Model
{
    protected $fillable = ['user_id','fileName','fileNameHash','isActive','type','link','text'];

    protected $appends = ['carousel','allies'];

    public function getCarouselAttribute()
    {
        return '/img/public/carousel/' . $this->fileNameHash;
    }
    public function getAlliesAttribute()
    {
        return '/img/public/allies/' . $this->fileNameHash;
    }
}
