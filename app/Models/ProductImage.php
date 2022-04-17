<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'file_id', 'image_url'];

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
