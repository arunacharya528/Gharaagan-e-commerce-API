<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'path'];

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'file_id');
    }

    public function brands()
    {
        return $this->hasMany(Brand::class, 'file_id');
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class, 'file_id');
    }
}
