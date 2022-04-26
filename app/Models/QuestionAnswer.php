<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id', 'query', 'parent_id'];

    public function answers()
    {
        return $this->hasMany(QuestionAnswer::class, 'parent_id');
    }

    public function questions()
    {
        return $this->answers()->with('questions');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
