<?php

namespace App\Models;

use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    public function category()
{
    return $this->belongsTo(Category::class);
}
}
