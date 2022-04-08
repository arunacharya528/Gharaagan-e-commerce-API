<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'summary', 'url_slug', 'page', 'type', 'active', 'active_from', 'active_to'];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
